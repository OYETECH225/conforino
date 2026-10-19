<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\Page;
use App\Models\SanitaryService;
use Symfony\Component\HttpFoundation\Response;

class SanitaryServiceController extends Controller
{
    use BuildsSeoView;

    public function index(): Response
    {
        $services = SanitaryService::query()->active()->ordered()->get();

        // Contenu éditorial de cette page (hero, bénéfices, étapes) géré comme
        // une Page CMS "cachée" (sans route publique dédiée) pour rester
        // éditable depuis l'admin, au même titre que la page Réalisations.
        $contentBlocks = Page::query()->where('slug', 'installation-sanitaire')->with('activeBlocks')->first()?->activeBlocks
            ?? collect();
        $heroBlock = $contentBlocks->firstWhere('type', 'hero');
        $benefitsBlock = $contentBlocks->firstWhere('type', 'feature_grid');
        $processBlock = $contentBlocks->firstWhere('type', 'process');

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Plomberie & installation sanitaire', 'url' => route('sanitary-services.index')],
        ];

        return response()->view('sanitary-services.index', array_merge([
            'services' => $services,
            'heroBlock' => $heroBlock,
            'benefitsBlock' => $benefitsBlock,
            'processBlock' => $processBlock,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => "Plomberie & installation sanitaire | CONFOR'INO Argenteuil",
            'description' => "Pose de robinetterie, WC, receveur de douche, meuble de salle de bain et barres d'appui à prix fixe, à Argenteuil et dans le Val-d'Oise. Devis gratuit.",
            'canonical' => route('sanitary-services.index'),
            'robots' => 'index,follow',
            'ogImage' => null,
        ], $breadcrumbs)));
    }

    public function priceSheet(): Response
    {
        $services = SanitaryService::query()->active()->ordered()->get();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Plomberie & installation sanitaire', 'url' => route('sanitary-services.index')],
            ['name' => 'Fiche tarifaire', 'url' => route('sanitary-services.price-sheet')],
        ];

        return response()->view('sanitary-services.price-sheet', array_merge([
            'services' => $services,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => "Fiche tarifaire — Plomberie & installation sanitaire | CONFOR'INO",
            'description' => "Tous nos tarifs de pose et d'installation sanitaire à prix fixe : robinetterie, WC, receveur de douche, meuble de salle de bain, barres d'appui.",
            'canonical' => route('sanitary-services.price-sheet'),
            'robots' => 'index,follow',
            'ogImage' => null,
        ], $breadcrumbs)));
    }

    public function show(string $slug): Response
    {
        $service = SanitaryService::query()->active()->where('slug', $slug)->firstOrFail();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Plomberie & installation sanitaire', 'url' => route('sanitary-services.index')],
            ['name' => $service->title, 'url' => route('sanitary-services.show', $service->slug)],
        ];

        return response()->view('sanitary-services.show', array_merge([
            'service' => $service,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => $service->metaTitle(),
            'description' => $service->metaDescription(),
            'canonical' => route('sanitary-services.show', $service->slug),
            'robots' => $service->robots,
            'ogImage' => null,
        ], $breadcrumbs)));
    }
}
