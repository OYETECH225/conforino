<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\City;
use App\Models\Realisation;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCity;
use App\Services\Seo\SchemaBuilder;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    use BuildsSeoView;

    /**
     * Résout /services/{slug}/ (page service seule) et /services/{slug}-{ville}/
     * (déclinaison locale) à partir du même modèle Service + un unique template,
     * sans jamais dupliquer de contenu en base pour chaque ville.
     */
    public function show(string $slug): Response
    {
        $service = Service::query()->active()->where('slug', $slug)->first();
        $city = null;
        $pivot = null;

        if (! $service) {
            [$service, $city, $pivot] = $this->resolveServiceCity($slug);
        }

        abort_if(! $service, 404);

        if ($city && (! $pivot || ! $pivot->is_published)) {
            abort(404);
        }

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Services', 'url' => route('services.index')],
        ];

        if ($city) {
            $breadcrumbs[] = ['name' => $service->title, 'url' => route('services.show', $service->slug)];
            $breadcrumbs[] = ['name' => $city->name, 'url' => route('services.show', $slug)];
        } else {
            $breadcrumbs[] = ['name' => $service->title, 'url' => route('services.show', $service->slug)];
        }

        $seo = $city
            ? [
                'title' => $service->metaTitleFor($city, $pivot),
                'description' => $service->metaDescriptionFor($city, $pivot),
                'canonical' => route('services.show', $slug),
                'robots' => $service->robots,
                'ogImage' => $service->imageUrl(),
            ]
            : [
                'title' => $service->metaTitle(),
                'description' => $service->metaDescription(),
                'canonical' => $service->canonical_url ?: route('services.show', $service->slug),
                'robots' => $service->robots,
                'ogImage' => $service->imageUrl(),
            ];

        $otherCities = $service->cities()->wherePivot('is_published', true)->when($city, fn ($q) => $q->where('cities.id', '!=', $city->id))->ordered()->limit(8)->get();

        $realisations = Realisation::query()
            ->published()
            ->where('service_id', $service->id)
            ->when($city, fn ($q) => $q->where('city_id', $city->id))
            ->ordered()
            ->limit(4)
            ->get();

        $reviews = Review::query()->published()
            ->when($city, fn ($q) => $q->where('city_id', $city->id))
            ->ordered()
            ->limit(4)
            ->get();

        return response()->view('services.show', array_merge([
            'service' => $service,
            'city' => $city,
            'pivot' => $pivot,
            'otherCities' => $otherCities,
            'realisations' => $realisations,
            'reviews' => $reviews,
            'showBreadcrumb' => true,
        ], $this->seoViewData($seo, $breadcrumbs, [
            app(SchemaBuilder::class)->service($service, $city),
        ])));
    }

    /**
     * @return array{0: ?Service, 1: ?City, 2: ?ServiceCity}
     */
    protected function resolveServiceCity(string $slug): array
    {
        foreach (Service::query()->active()->get() as $service) {
            $prefix = $service->slug.'-';

            if (! Str::startsWith($slug, $prefix)) {
                continue;
            }

            $citySlug = Str::after($slug, $prefix);
            $city = City::query()->active()->where('slug', $citySlug)->first();

            if (! $city) {
                continue;
            }

            $pivot = ServiceCity::query()
                ->where('service_id', $service->id)
                ->where('city_id', $city->id)
                ->first();

            if ($pivot) {
                return [$service, $city, $pivot];
            }
        }

        return [null, null, null];
    }
}
