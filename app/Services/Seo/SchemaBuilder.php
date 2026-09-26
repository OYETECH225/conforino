<?php

namespace App\Services\Seo;

use App\Models\City;
use App\Models\Review;
use App\Models\Service;
use App\Settings\GeneralSettings;
use Spatie\SchemaOrg\Schema;

/**
 * Construit les blocs JSON-LD (Schema.org) attendus par le cahier des charges :
 * LocalBusiness sur toutes les pages, Service sur les pages prestation,
 * FAQPage sur les blocs FAQ, BreadcrumbList partout sauf l'accueil,
 * AggregateRating dès que des avis sont présents.
 */
class SchemaBuilder
{
    public function __construct(protected GeneralSettings $settings) {}

    public function localBusiness(): array
    {
        $business = Schema::localBusiness()
            ->name($this->settings->company_name)
            ->image(asset('images/logo-social.png'))
            ->telephone($this->settings->call_tracking_phone ?: $this->settings->phone)
            ->email($this->settings->email)
            ->address(
                Schema::postalAddress()
                    ->streetAddress($this->settings->address_street)
                    ->addressLocality($this->settings->address_city)
                    ->postalCode($this->settings->address_postal_code)
                    ->addressCountry('FR')
            )
            ->url(url('/'))
            ->areaServed(
                City::query()->active()->ordered()->pluck('name')->map(
                    fn (string $name) => Schema::place()->name($name)
                )->all()
            );

        $reviews = Review::query()->published()->get();

        if ($reviews->isNotEmpty()) {
            $business->aggregateRating($this->aggregateRating($reviews));
        }

        return $business->toArray();
    }

    public function aggregateRating($reviews): \Spatie\SchemaOrg\AggregateRating
    {
        $count = $reviews->count();
        $average = round($reviews->avg('rating'), 1);

        return Schema::aggregateRating()
            ->ratingValue($average)
            ->reviewCount($count)
            ->bestRating(5)
            ->worstRating(1);
    }

    public function breadcrumbs(array $items): array
    {
        // $items = [['name' => 'Accueil', 'url' => '/'], ...]
        $list = Schema::breadcrumbList();
        $elements = [];

        foreach ($items as $index => $item) {
            $elements[] = Schema::listItem()
                ->position($index + 1)
                ->name($item['name'])
                ->item($item['url']);
        }

        return $list->itemListElement($elements)->toArray();
    }

    public function service(Service $service, ?City $city = null): array
    {
        $schema = Schema::service()
            ->serviceType($service->title)
            ->name($city ? "{$service->title} à {$city->name}" : $service->title)
            ->description($service->short_description)
            ->provider($this->businessRef())
            ->areaServed($city?->name ?: 'Val-d\'Oise');

        return $schema->toArray();
    }

    public function faqPage(array $items): array
    {
        $questions = collect($items)->map(
            fn (array $item) => Schema::question()
                ->name(strip_tags($item['question']))
                ->acceptedAnswer(
                    Schema::answer()->text(strip_tags($item['answer']))
                )
        )->all();

        return Schema::fAQPage()->mainEntity($questions)->toArray();
    }

    protected function businessRef(): \Spatie\SchemaOrg\LocalBusiness
    {
        return Schema::localBusiness()->name($this->settings->company_name)->url(url('/'));
    }

    /**
     * Fusionne plusieurs schémas dans un unique <script type="application/ld+json">
     * via @graph, plutôt que de multiplier les balises <script>.
     */
    public function combine(array $schemas): string
    {
        $graph = collect($schemas)
            ->filter()
            ->map(fn (array $schema) => \Illuminate\Support\Arr::except($schema, '@context'))
            ->values()
            ->all();

        return json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
