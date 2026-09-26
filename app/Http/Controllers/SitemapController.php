<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Realisation;
use App\Models\Service;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    /**
     * Génère le sitemap.xml à la volée à partir du contenu publié : toujours
     * à jour, sans étape de régénération manuelle après une publication.
     */
    public function __invoke(): Response
    {
        $sitemap = Sitemap::create();

        foreach (Page::query()->published()->get() as $page) {
            $sitemap->add(
                Url::create($page->slug === 'accueil' ? '/' : '/'.$page->slug)
                    ->setLastModificationDate($page->updated_at)
                    ->setPriority($page->slug === 'accueil' ? 1.0 : 0.6)
            );
        }

        $sitemap->add(Url::create(route('services.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('realisations.index'))->setPriority(0.6));
        $sitemap->add(Url::create(route('reviews.index'))->setPriority(0.5));
        $sitemap->add(Url::create(route('cities.index'))->setPriority(0.5));

        foreach (Service::query()->active()->get() as $service) {
            $sitemap->add(
                Url::create(route('services.show', $service->slug))
                    ->setLastModificationDate($service->updated_at)
                    ->setPriority(0.9)
            );

            foreach ($service->cities()->wherePivot('is_published', true)->get() as $city) {
                $sitemap->add(
                    Url::create(route('services.show', $service->slug.'-'.$city->slug))
                        ->setPriority(0.7)
                );
            }
        }

        foreach (Realisation::query()->published()->get() as $realisation) {
            $sitemap->add(
                Url::create(route('realisations.show', $realisation->slug))
                    ->setLastModificationDate($realisation->updated_at)
                    ->setPriority(0.4)
            );
        }

        return response($sitemap->render(), 200, ['Content-Type' => 'application/xml']);
    }
}
