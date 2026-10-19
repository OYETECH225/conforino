<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RealisationController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SanitaryServiceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::get('/services', [PageController::class, 'show'])
    ->defaults('slug', 'services')
    ->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/realisations', [RealisationController::class, 'index'])->name('realisations.index');
Route::get('/realisations/{slug}', [RealisationController::class, 'show'])->name('realisations.show');

Route::get('/zones-d-intervention', [CityController::class, 'index'])->name('cities.index');

Route::get('/installation-sanitaire', [SanitaryServiceController::class, 'index'])->name('sanitary-services.index');
Route::get('/installation-sanitaire/tarifs', [SanitaryServiceController::class, 'priceSheet'])->name('sanitary-services.price-sheet');
Route::get('/installation-sanitaire/{slug}', [SanitaryServiceController::class, 'show'])->name('sanitary-services.show');

// Catch-all CMS : doit rester en dernier (FAQ, Contact, mentions légales, etc.)
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('page.show');
