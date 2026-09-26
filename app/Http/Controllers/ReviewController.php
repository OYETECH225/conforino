<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\Review;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    use BuildsSeoView;

    public function index(): Response
    {
        $reviews = Review::query()->published()->ordered()->with('city')->get();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => 'Avis clients', 'url' => route('reviews.index')],
        ];

        // L'AggregateRating est déjà injecté dans le schéma LocalBusiness
        // (présent sur chaque page) dès qu'il existe des avis publiés.
        return response()->view('reviews.index', array_merge([
            'reviews' => $reviews,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => "Avis clients | CONFOR'INO Argenteuil",
            'description' => "Découvrez les avis de nos clients sur nos travaux de rénovation, agencement cuisine/salle de bain et adaptation PMR dans le Val-d'Oise.",
            'canonical' => route('reviews.index'),
            'robots' => 'index,follow',
            'ogImage' => null,
        ], $breadcrumbs)));
    }
}
