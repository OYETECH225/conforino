<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\Realisation;
use Symfony\Component\HttpFoundation\Response;

class RealisationController extends Controller
{
    use BuildsSeoView;

    public function index(): Response
    {
        $realisations = Realisation::query()->published()->ordered()->with(['service', 'city'])->get();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Réalisations', 'url' => route('realisations.index')],
        ];

        return response()->view('realisations.index', array_merge([
            'realisations' => $realisations,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => "Nos réalisations avant/après | CONFOR'INO",
            'description' => "Découvrez les chantiers de rénovation, agencement cuisine, salle de bain et adaptation PMR réalisés par CONFOR'INO dans le Val-d'Oise.",
            'canonical' => route('realisations.index'),
            'robots' => 'index,follow',
            'ogImage' => null,
        ], $breadcrumbs)));
    }

    public function show(string $slug): Response
    {
        $realisation = Realisation::query()->published()->where('slug', $slug)->with(['service', 'city'])->firstOrFail();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Réalisations', 'url' => route('realisations.index')],
            ['name' => $realisation->title, 'url' => route('realisations.show', $realisation->slug)],
        ];

        return response()->view('realisations.show', array_merge([
            'realisation' => $realisation,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => $realisation->meta_title ?: $realisation->title." | CONFOR'INO",
            'description' => $realisation->meta_description ?: $realisation->description,
            'canonical' => route('realisations.show', $realisation->slug),
            'robots' => 'index,follow',
            'ogImage' => $realisation->afterUrl(),
        ], $breadcrumbs)));
    }
}
