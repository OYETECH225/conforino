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
            '/services/entreprise-cuisine-95/' => '/services/renovation-salle-de-bain-cuisine',
            '/services/entreprise-renovation-95/' => '/services/renovation-interieure',
            '/conditions-generales-de-vente-et-dexecution-des-travaux' => '/conditions-generales-de-vente',

            // Fusion de "Agencement cuisine" et "Agencement salle de bain" en
            // un seul service "Rénovation salle de bain et cuisine" (demande
            // client) : ces deux URLs de notre propre site restent couvertes.
            '/services/agencement-cuisine' => '/services/renovation-salle-de-bain-cuisine',
            '/services/agencement-salle-de-bain' => '/services/renovation-salle-de-bain-cuisine',

            // Nouvelle section "Plomberie & installation sanitaire", reprise
            // depuis l'ancien site avec le nouveau design (cf. SanitaryServiceSeeder).
            '/installation-sanitaire-val-doise/' => '/installation-sanitaire',
            '/installation-dun-robinet-de-cuisine/' => '/installation-sanitaire/robinet-cuisine',
            '/installation-dun-evier-et-son-robinet/' => '/installation-sanitaire/evier-et-robinet',
            '/remplacement-dun-wc-a-poser-broyeur/' => '/installation-sanitaire/wc-a-poser-broyeur',
            '/installation-dun-robinet-de-salle-de-bain/' => '/installation-sanitaire/robinet-salle-de-bain',
            '/installation-dune-colonne-de-douche-et-sa-robinetterie/' => '/installation-sanitaire/colonne-de-douche',
            '/pose-et-installation-dun-meuble-de-salle-de-bain-pre-monte/' => '/installation-sanitaire/meuble-salle-de-bain-pre-monte',
            '/pose-meuble-en-kit/' => '/installation-sanitaire/meuble-salle-de-bain-en-kit',
            '/pose-et-installation-dun-receveur-de-douche/' => '/installation-sanitaire/receveur-de-douche',
            '/pose-et-installation-de-barres-dappui/' => '/installation-sanitaire/barres-appui',
            // Page "Avis clients" dédiée retirée : les avis restent visibles sur
            // l'accueil et les pages service (bloc témoignages), qui suffisent
            // pour le volume d'avis actuel.
            '/avis' => '/',
        ];

        foreach ($map as $from => $to) {
            // Le modèle Redirect normalise from_path (retire le slash final) à
            // la sauvegarde : on applique la même normalisation ici pour que
            // updateOrCreate retrouve bien la ligne existante lors des reseed
            // successifs, plutôt que de tenter une réinsertion en doublon.
            Redirect::query()->updateOrCreate(
                ['from_path' => '/'.trim($from, '/')],
                ['to_path' => $to, 'status_code' => 301, 'is_active' => true]
            );
        }
    }
}
