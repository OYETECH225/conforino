<?php

namespace Database\Seeders;

use App\Models\SanitaryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Nouvelle section "Plomberie & installation sanitaire" ajoutée par le client
 * sur l'ancien site conforino.fr (/installation-sanitaire-val-doise/ et ses
 * 9 pages de prestation à prix fixe), reprise ici avec le nouveau design.
 *
 * 3 prestations (pare-baignoire, paroi de douche italienne, radiateur /
 * sèche-serviette) sont listées avec leur prix sur l'ancienne page catégorie
 * mais n'ont pas encore de page de détail dédiée sur l'ancien site : leurs
 * champs "inclus / non inclus / durée / à fournir" sont volontairement
 * laissés vides plutôt que d'inventer un contenu qui n'existe pas encore.
 */
class SanitaryServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => "Installation d'un robinet de cuisine",
                'slug' => 'robinet-cuisine',
                'icon' => 'kitchen',
                'image' => $this->seedImage('cuisine-1.jpg'),
                'price' => 129,
                'price_note' => 'Prix TTC pour une installation standard.',
                'duration_label' => 'Environ 1 heure',
                'short_description' => "Vous avez acheté votre robinet de cuisine, confiez-nous son installation.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien robinet en déchetterie",
                ],
                'excluded_items' => [
                    'Dépose d\'un robinet encastré au mur', "Perçage d'un évier ou d'un plan de travail",
                    "Déplacement de l'arrivée d'eau",
                ],
                'client_provides' => ['Le robinet de cuisine'],
            ],
            [
                'title' => "Installation d'un évier et son robinet",
                'slug' => 'evier-et-robinet',
                'icon' => 'kitchen',
                'image' => $this->seedImage('cuisine-2.jpg'),
                'price' => 229,
                'price_note' => 'Prix TTC pour une installation standard.',
                'duration_label' => '2 à 3 heures',
                'short_description' => "Vous avez acheté votre évier et son robinet, confiez-nous une installation complète.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien évier et robinet en déchetterie", 'Dépose des anciens équipements',
                    'Découpe du plan de travail si nécessaire pour l\'évier',
                    'Installation de l\'évier et du robinet avec perçage si besoin',
                    'Nettoyage du chantier et évacuation des emballages',
                ],
                'excluded_items' => [
                    "Installation d'un robinet mural", 'Réduction de la découpe du plan de travail sous la cuve',
                    "Déplacement de l'arrivée ou de l'évacuation d'eau",
                ],
                'client_provides' => ["L'évier et le robinet à installer", 'Un siphon (si remplacement nécessaire)'],
            ],
            [
                'title' => "Remplacement d'un WC à poser/broyeur",
                'slug' => 'wc-a-poser-broyeur',
                'icon' => 'plumbing',
                'image' => $this->seedImage('renovation-plomberie.webp'),
                'price' => 249,
                'price_note' => "Prix TTC pour une installation standard, sous réserve d'éligibilité à la TVA réduite et conditions d'application.",
                'duration_label' => '2 à 3 heures',
                'short_description' => "Remplacement de votre WC à poser ou broyeur, que vous avez acheté.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien WC en déchetterie", 'Dépose du WC existant',
                    'Remplacement du tuyau de raccordement',
                    "Remplacement du flexible d'alimentation et du robinet d'arrêt si nécessaire",
                    'Installation et raccordement aux canalisations existantes',
                    'Nettoyage du chantier et évacuation des emballages',
                ],
                'excluded_items' => [
                    "Dépose d'un WC suspendu",
                    "Déplacement de l'arrivée d'eau, de l'évacuation ou d'une prise électrique (broyeur)",
                ],
                'client_provides' => ['Le WC à poser', "Un robinet d'arrêt et un flexible d'alimentation (recommandé)"],
            ],
            [
                'title' => "Installation d'un robinet de salle de bain",
                'slug' => 'robinet-salle-de-bain',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-1.jpg'),
                'price' => 129,
                'price_note' => "Prix TTC pour une installation standard, hors prestations optionnelles et sous réserve d'éligibilité à la TVA réduite.",
                'duration_label' => 'Environ 1 heure',
                'short_description' => "Vous avez acheté votre robinet de salle de bain, confiez-nous son installation.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien robinet en déchetterie",
                ],
                'excluded_items' => [
                    'Dépose d\'un robinet encastré au mur', "Perçage d'une vasque ou d'un plan de travail",
                    "Déplacement de l'arrivée d'eau",
                ],
                'client_provides' => [
                    'Le robinet de salle de bain et ses raccords éventuels',
                    'Une paire d\'équerres si besoin (pose sur baignoire)',
                ],
            ],
            [
                'title' => "Installation d'une colonne de douche et sa robinetterie",
                'slug' => 'colonne-de-douche',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-2.jpg'),
                'price' => 149,
                'price_note' => 'Prix TTC pour une installation standard.',
                'duration_label' => '1 à 2 heures en moyenne',
                'short_description' => "Installation de votre colonne de douche et sa robinetterie, que vous avez achetée.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancienne colonne en déchetterie", "Dépose de l'ancien équipement",
                    "Raccordement à l'arrivée d'eau existante", 'Fixation murale de la nouvelle colonne',
                    'Nettoyage du chantier et évacuation des emballages',
                ],
                'excluded_items' => [
                    'Dépose d\'une colonne de douche encastrée dans le mur', "Déplacement de l'arrivée d'eau",
                ],
                'client_provides' => ['La colonne de douche et sa robinetterie (neuve, complète et compatible avec l\'installation existante)'],
            ],
            [
                'title' => "Pose et installation d'un meuble de salle de bain pré-monté",
                'slug' => 'meuble-salle-de-bain-pre-monte',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-1.jpg'),
                'price' => 297,
                'price_note' => "Prix TTC pour une installation standard, sous réserve d'éligibilité à la TVA réduite.",
                'duration_label' => '1 à 2 heures',
                'short_description' => "Pose de votre meuble de salle de bain pré-monté, que vous avez acheté et déjà assemblé.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien meuble si besoin", "Dépose de l'ancien meuble",
                    'Installation du nouveau meuble', 'Nettoyage du chantier et évacuation des emballages',
                ],
                'excluded_items' => [
                    'Le meuble de salle de bain lui-même', 'Toute adaptation ou modification technique en dehors de la pose standard',
                ],
                'client_provides' => ['Le meuble de salle de bain pré-monté (neuf, complet et compatible avec l\'installation existante)'],
            ],
            [
                'title' => "Pose et installation d'un meuble de salle de bain en kit",
                'slug' => 'meuble-salle-de-bain-en-kit',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-2.jpg'),
                'price' => 379.90,
                'price_note' => "Prix TTC pour une installation standard, hors prestations optionnelles et sous réserve d'éligibilité à la TVA réduite.",
                'duration_label' => '1 à 2 heures en moyenne',
                'short_description' => "Montage et pose de votre meuble de salle de bain en kit, que vous avez acheté.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Dépose et évacuation de l'ancien meuble si besoin", 'Montage du meuble en kit',
                    'Installation', 'Nettoyage du chantier et évacuation des emballages',
                ],
                'excluded_items' => ['Le meuble lui-même', 'Toute adaptation ou modification technique imprévue'],
                'client_provides' => ['Le meuble de salle de bain en kit (neuf, complet et compatible avec l\'installation existante)'],
            ],
            [
                'title' => "Pose et installation d'un receveur de douche",
                'slug' => 'receveur-de-douche',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-1.jpg'),
                'price' => 280,
                'price_is_from' => true,
                'price_note' => "Prix TTC de départ pour une installation standard, hors options éventuelles et sous réserve d'éligibilité à la TVA réduite.",
                'duration_label' => '2 à 3 heures pour une intervention standard',
                'short_description' => "Pose de votre receveur de douche, que vous avez acheté.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancien receveur en déchetterie", "Dépose du receveur existant si nécessaire",
                    'Raccordement aux canalisations existantes', 'Nettoyage du chantier et évacuation des emballages',
                ],
                'client_provides' => ['Le receveur de douche (neuf, complet et compatible avec l\'installation existante)'],
                'extra_note' => "Travaux soumis à vérification de la faisabilité technique sur place. Toute complication imprévue peut faire l'objet d'un devis complémentaire, soumis à votre accord avant exécution.",
            ],
            [
                'title' => 'Pose et installation de barres d\'appui',
                'slug' => 'barres-appui',
                'icon' => 'pmr',
                'image' => $this->seedImage('pmr-2.jpg'),
                'price' => 89,
                'price_note' => 'Prix TTC pour une installation standard.',
                'duration_label' => 'Environ 1 heure',
                'short_description' => "Installation de barres d'appui sécurisées, que vous avez achetées.",
                'included_items' => [
                    'Déplacement du technicien', "Main d'œuvre", 'Petites fournitures',
                    "Évacuation de l'ancienne barre d'appui (le cas échéant)",
                ],
                'client_provides' => ["La barre d'appui"],
            ],

            // Prestations listées avec leur prix sur l'ancienne page catégorie,
            // mais sans page de détail dédiée existante : contenu minimal,
            // volontairement sans détails inventés (inclus/durée/à fournir).
            [
                'title' => "Installation d'un pare-baignoire",
                'slug' => 'pare-baignoire',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-2.jpg'),
                'price' => 149,
                'short_description' => "Vous avez acheté votre pare-baignoire, confiez-nous son installation.",
            ],
            [
                'title' => "Installation d'une paroi de douche à l'italienne format standard",
                'slug' => 'paroi-douche-italienne',
                'icon' => 'bathroom',
                'image' => $this->seedImage('salle-de-bain-1.jpg'),
                'price' => 229,
                'short_description' => "Vous avez acheté votre paroi de douche à l'italienne au format standard, confiez-nous son installation.",
            ],
            [
                'title' => "Installation d'un radiateur électrique ou sèche-serviette",
                'slug' => 'radiateur-electrique-seche-serviette',
                'icon' => 'electricity',
                'price' => 149,
                'short_description' => "Vous avez acheté votre radiateur électrique ou sèche-serviette, confiez-nous son installation.",
            ],
        ];

        foreach ($services as $index => $data) {
            SanitaryService::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'icon' => $data['icon'],
                    'image' => $data['image'] ?? null,
                    'short_description' => $data['short_description'],
                    'price' => $data['price'],
                    'price_is_from' => $data['price_is_from'] ?? false,
                    'price_note' => $data['price_note'] ?? null,
                    'duration_label' => $data['duration_label'] ?? null,
                    'included_items' => $data['included_items'] ?? null,
                    'excluded_items' => $data['excluded_items'] ?? null,
                    'client_provides' => $data['client_provides'] ?? null,
                    'extra_note' => $data['extra_note'] ?? null,
                    'is_active' => true,
                    'order' => $index,
                    'robots' => 'index,follow',
                ]
            );
        }
    }

    /**
     * Copie une photo existante (déjà utilisée ailleurs sur le site, réelle et
     * non générique) vers le disque public pour illustrer la prestation :
     * aucune de ces 12 prestations n'a de photo de chantier propre à ce jour,
     * ces visuels restent donc des illustrations de principe par catégorie
     * (cuisine, salle de bain, PMR...), à remplacer par l'admin dès que des
     * photos réelles de chantier "installation sanitaire" seront disponibles.
     */
    protected function seedImage(string $filename): ?string
    {
        $source = database_path('seeders/assets/'.$filename);

        if (! file_exists($source)) {
            return null;
        }

        $target = 'sanitary-services/'.$filename;
        Storage::disk('public')->put($target, file_get_contents($source));

        return $target;
    }
}
