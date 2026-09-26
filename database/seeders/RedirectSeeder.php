<?php

namespace Database\Seeders;

use App\Models\Redirect;
use Illuminate\Database\Seeder;

/**
 * 301 depuis les URLs de l'ancien site conforino.fr vers l'arborescence du
 * nouveau site, pour ne perdre aucun positionnement lors de la migration.
 */
class RedirectSeeder extends Seeder
{
    public function run(): void
    {
        // Seules les URLs dont le slug change réellement ont besoin d'une 301 :
        // les anciennes URLs qui ne différaient que par le "/" final (faq/,
        // contact/, mentions-legales/...) sont déjà résolues nativement par
        // Laravel (Request::path() ignore le slash final), et
        // /services/amenagement-pmr-argenteuil/ correspond désormais
        // directement à la nouvelle déclinaison "PMR à Argenteuil" — inutile
        // et même contre-productif d'y ajouter une redirection.
        $map = [
            '/our-services/' => '/services',
            '/services/entreprise-cuisine-95/' => '/services/agencement-cuisine',
            '/services/entreprise-renovation-95/' => '/services/renovation-interieure',
            '/installation-sanitaire-val-doise/' => '/services/renovation-interieure',
            '/conditions-generales-de-vente-et-dexecution-des-travaux' => '/conditions-generales-de-vente',
            // Page "Avis clients" dédiée retirée : les avis restent visibles sur
            // l'accueil et les pages service (bloc témoignages), qui suffisent
            // pour le volume d'avis actuel.
            '/avis' => '/',
        ];

        foreach ($map as $from => $to) {
            Redirect::query()->updateOrCreate(
                ['from_path' => $from],
                ['to_path' => $to, 'status_code' => 301, 'is_active' => true]
            );
        }
    }
}
