<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\City;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    use BuildsSeoView;

    public function index(): Response
    {
        $cities = City::query()->active()->ordered()
            ->with(['services' => fn ($q) => $q->wherePivot('is_published', true)->active()->ordered()])
            ->get();

        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => url('/')],
            ['name' => "Zones d'intervention", 'url' => route('cities.index')],
        ];

        return response()->view('cities.index', array_merge([
            'cities' => $cities,
            'showBreadcrumb' => true,
        ], $this->seoViewData([
            'title' => "Zones d'intervention dans le Val-d'Oise | CONFOR'INO",
            'description' => "CONFOR'INO intervient à Argenteuil et dans les communes voisines du Val-d'Oise pour vos travaux de rénovation, agencement et adaptation PMR.",
            'canonical' => route('cities.index'),
            'robots' => 'index,follow',
            'ogImage' => null,
        ], $breadcrumbs)));
    }
}
