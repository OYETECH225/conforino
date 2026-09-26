<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Contenu repris et adapté des pages services de l'ancien site conforino.fr
 * (/services/amenagement-pmr-argenteuil/, /services/entreprise-cuisine-95/,
 * /services/entreprise-renovation-95/), reformaté pour ce nouveau modèle
 * de données. Les descriptions longues sont éditables dans l'admin.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Aménagement PMR',
                'slug' => 'amenagement-pmr',
                'icon' => 'pmr',
                'short_description' => "Douches sécurisées, salles de bain PMR, rampes d'accès, mains courantes et dalles podotactiles : nous adaptons votre logement pour plus de confort, d'accessibilité et de sécurité au quotidien.",
                'long_description' => "<p>CONFOR'INO adapte votre salle de bain et votre logement pour améliorer le confort, l'accessibilité et la sécurité : douche accessible de plain-pied, remplacement de baignoire par une douche à l'italienne, barres d'appui, siège de douche et équipements adaptés.</p><p>Nous réalisons également la pose de rampes d'accès sur mesure, de mains courantes et de dalles ou clous podotactiles pour les personnes malvoyantes. Chaque projet fait l'objet d'une étude personnalisée pour s'adapter précisément à vos besoins et à la configuration de votre logement.</p>",
            ],
            [
                'title' => 'Agencement cuisine',
                'slug' => 'agencement-cuisine',
                'icon' => 'kitchen',
                'short_description' => 'Conception et installation de cuisines sur mesure, fonctionnelles et durables, adaptées à votre espace et à votre budget.',
                'long_description' => "<p>Nous concevons et installons des cuisines sur mesure : conception et plans 3D personnalisés, choix des matériaux, agencement optimisé et pose complète (meubles, plan de travail, électroménager, raccordements).</p><p>Notre approche privilégie l'écoute, le conseil et l'exigence, avec un interlocuteur unique qui suit votre projet du premier échange jusqu'aux finitions.</p>",
            ],
            [
                'title' => 'Agencement salle de bain',
                'slug' => 'agencement-salle-de-bain',
                'icon' => 'bathroom',
                'short_description' => 'Création ou rénovation de salle de bain clé en main : douche à l\'italienne, meubles, faïence et finitions.',
                'long_description' => "<p>Nous créons ou rénovons votre salle de bain de A à Z : remplacement de baignoire par une douche à l'italienne, pose de meubles, faïence, plomberie et électricité, jusqu'aux finitions.</p><p>Chaque projet est pensé pour votre quotidien, avec un accompagnement complet et personnalisé, du premier échange à la réception du chantier.</p>",
            ],
            [
                'title' => 'Rénovation intérieure',
                'slug' => 'renovation-interieure',
                'icon' => 'renovation',
                'short_description' => 'Travaux de rénovation intérieure pour appartements, maisons et locaux professionnels : peinture, revêtements, plomberie, électricité et finitions.',
                'long_description' => "<p>Nous réalisons vos travaux de rénovation intérieure dans les appartements, maisons et locaux professionnels : plomberie (réseaux d'eau et d'évacuation, installation sanitaire), mise aux normes et travaux d'électricité, peinture et finitions intérieures, création de cloisons et aménagement d'espaces.</p><p>Nous coordonnons l'ensemble des travaux dans une logique de qualité, de transparence et de respect des délais, avec un interlocuteur unique pour tout le chantier.</p>",
            ],
        ];

        $cities = City::query()->ordered()->get();

        foreach ($services as $index => $data) {
            $service = Service::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'icon' => $data['icon'],
                    'short_description' => $data['short_description'],
                    'long_description' => $data['long_description'],
                    'is_active' => true,
                    'order' => $index,
                    'robots' => 'index,follow',
                ]
            );

            foreach ($cities as $city) {
                $service->cities()->syncWithoutDetaching([
                    $city->id => [
                        'local_intro' => $this->localIntro($data['title'], $city->name),
                        'is_published' => true,
                    ],
                ]);
            }
        }
    }

    /**
     * Paragraphe de départ, à personnaliser dans l'admin pour chaque ville :
     * variation volontaire du texte pour éviter le duplicate content, en
     * attendant que l'équipe CONFOR'INO affine chaque déclinaison locale.
     */
    protected function localIntro(string $serviceTitle, string $cityName): string
    {
        $templates = [
            "CONFOR'INO réalise vos travaux de {service} à {ville}, avec la même exigence de qualité et de transparence que sur l'ensemble de notre secteur d'intervention dans le Val-d'Oise.",
            "À {ville}, notre équipe intervient pour des projets de {service}, du premier échange jusqu'à la réception du chantier, avec un devis gratuit et sans engagement.",
            "Basée à Argenteuil, l'équipe CONFOR'INO se déplace régulièrement à {ville} pour des chantiers de {service}, en s'adaptant aux spécificités du bâti local.",
        ];

        $template = $templates[crc32($cityName) % count($templates)];

        return strtr($template, [
            '{service}' => mb_strtolower($serviceTitle),
            '{ville}' => $cityName,
        ]);
    }
}
