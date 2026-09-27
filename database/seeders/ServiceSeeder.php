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
                'long_description' => "<p>Vieillissement, perte de mobilité, handicap ou simple souci de sécurité au quotidien : l'aménagement PMR (personnes à mobilité réduite) consiste à adapter un logement existant pour qu'il reste sûr et confortable, sans attendre un accident. CONFOR'INO intervient à Argenteuil et dans tout le Val-d'Oise pour transformer une salle de bain ou un logement standard en espace accessible, sans le rendre médicalisé pour autant.</p>"
                    ."<p>Notre prestation la plus demandée reste le remplacement d'une baignoire par une douche à l'italienne de plain-pied, avec receveur extra-plat, siège de douche rabattable, barres d'appui positionnées selon vos besoins réels (et non un standard générique), et robinetterie thermostatique facile à manipuler. Nous posons également des mains courantes et rampes d'accès sur mesure pour sécuriser un escalier ou une entrée, ainsi que des dalles et clous podotactiles répondant aux normes d'accessibilité pour les personnes malvoyantes.</p>"
                    ."<p>Chaque projet démarre par une visite technique gratuite à votre domicile : nous observons la configuration réelle du logement (largeur des portes, dénivelés, réseaux existants) avant de proposer des solutions concrètes plutôt qu'un catalogue standard. Les travaux sont ensuite coordonnés par un interlocuteur unique, du premier rendez-vous à la réception de chantier.</p>"
                    ."<ul><li>Douches sécurisées et receveurs extra-plats</li><li>Barres d'appui et mains courantes sur mesure</li><li>Rampes d'accès et suppression des seuils</li><li>Dalles et clous podotactiles</li><li>Devis gratuit après visite technique</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale (Groupama).</p>",
            ],
            [
                'title' => 'Agencement cuisine',
                'slug' => 'agencement-cuisine',
                'icon' => 'kitchen',
                'short_description' => 'Conception et installation de cuisines sur mesure, fonctionnelles et durables, adaptées à votre espace et à votre budget.',
                'long_description' => "<p>Une cuisine se pense d'abord en fonction de vos habitudes réelles : cuisiner seul ou à plusieurs, recevoir, ranger, circuler. CONFOR'INO conçoit et installe des cuisines sur mesure à Argenteuil et dans le Val-d'Oise, en partant systématiquement d'une étude de votre espace et de vos usages plutôt que d'un catalogue de modèles standards.</p>"
                    ."<p>Chaque projet démarre par une conception personnalisée avec plans 3D, pour visualiser l'agencement avant tout achat : implantation en L, en U, en îlot ou cuisine ouverte sur le séjour, optimisation du triangle d'activité (évier, cuisson, réfrigérateur), et choix des matériaux (façades, plan de travail, crédence) adaptés à votre budget. Nous coordonnons ensuite l'ensemble des corps de métier : dépose de l'ancienne cuisine, plomberie et électricité, pose des meubles et de l'électroménager, raccordements, jusqu'aux finitions.</p>"
                    ."<p>Notre approche privilégie l'écoute et la transparence sur les délais et les coûts, avec un interlocuteur unique qui suit votre chantier du premier échange à la réception des travaux — sans multiplier les intervenants ni les surprises de dernière minute.</p>"
                    ."<ul><li>Conception et plans 3D personnalisés</li><li>Cuisine ouverte, îlot ou implantation classique</li><li>Plomberie, électricité et raccordement électroménager</li><li>Choix des matériaux selon votre budget</li><li>Devis gratuit et sans engagement</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale.</p>",
            ],
            [
                'title' => 'Agencement salle de bain',
                'slug' => 'agencement-salle-de-bain',
                'icon' => 'bathroom',
                'short_description' => 'Création ou rénovation de salle de bain clé en main : douche à l\'italienne, meubles, faïence et finitions.',
                'long_description' => "<p>Douche à l'italienne, meuble suspendu, faïence en grand format ou petite salle de bain à optimiser au centimètre près : CONFOR'INO crée et rénove des salles de bain à Argenteuil et dans le Val-d'Oise, du studio à la salle de bain parentale, en tenant compte des contraintes réelles de chaque logement (réseaux existants, surface, luminosité).</p>"
                    ."<p>Nos chantiers incluent le remplacement de baignoire par une douche à l'italienne avec receveur extra-plat, la pose de meubles vasque et de faïence, la reprise de plomberie et d'électricité (VMC, éclairage, prises), ainsi que le traitement de l'étanchéité — un point souvent négligé qui conditionne pourtant la durabilité du chantier. Nous travaillons aussi bien sur une rénovation complète que sur des interventions ciblées : remplacement d'une paroi de douche, pose d'un meuble, changement de robinetterie.</p>"
                    ."<p>Chaque projet est pensé pour votre quotidien plutôt que pour l'effet de style seul, avec un accompagnement complet et personnalisé, du premier échange à la réception du chantier, assuré par un interlocuteur unique.</p>"
                    ."<ul><li>Douche à l'italienne et remplacement de baignoire</li><li>Meubles, faïence et robinetterie</li><li>Plomberie, électricité et étanchéité</li><li>Optimisation des petites surfaces</li><li>Devis gratuit après étude de votre espace</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale.</p>",
            ],
            [
                'title' => 'Rénovation intérieure',
                'slug' => 'renovation-interieure',
                'icon' => 'renovation',
                'short_description' => 'Travaux de rénovation intérieure pour appartements, maisons et locaux professionnels : peinture, revêtements, plomberie, électricité et finitions.',
                'long_description' => "<p>Rénover un appartement, une maison ou un local professionnel implique de coordonner plusieurs corps de métier sans perdre de vue le budget ni les délais. CONFOR'INO réalise vos travaux de rénovation intérieure à Argenteuil et dans le Val-d'Oise, du simple rafraîchissement à la rénovation complète, avec un seul interlocuteur pour l'ensemble du chantier.</p>"
                    ."<p>Nos équipes interviennent sur la plomberie (réseaux d'eau et d'évacuation, installation sanitaire), la mise aux normes et les travaux d'électricité (tableau électrique, prises, éclairage), la peinture et les finitions intérieures (murs, sols, plinthes), ainsi que la création de cloisons et l'aménagement d'espaces pour reconfigurer une pièce ou optimiser une surface. Nous intervenons aussi bien pour des particuliers que pour des professionnels souhaitant rénover un local commercial ou un bureau.</p>"
                    ."<p>Nous coordonnons l'ensemble des travaux dans une logique de qualité, de transparence sur les coûts et de respect des délais annoncés au devis, avec des points d'étape réguliers plutôt qu'un chantier qui s'éternise sans visibilité.</p>"
                    ."<ul><li>Plomberie et installation sanitaire</li><li>Électricité et mise aux normes</li><li>Peinture et finitions intérieures</li><li>Cloisons et aménagement d'espaces</li><li>Devis gratuit, particuliers et professionnels</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale.</p>",
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
        // lcfirst (et non mb_strtolower) pour ne minuscule que la première
        // lettre : préserve l'acronyme "PMR" au lieu de le transformer en "pmr".
        $service = lcfirst($serviceTitle);

        // Élision ("d'aménagement" et non "de aménagement") dès que le nom
        // de prestation commence par une voyelle.
        $de = preg_match('/^[aeiouyâàäéèêëîïôöûüù]/i', $service) ? "d'" : 'de ';

        $templates = [
            "CONFOR'INO réalise vos travaux {$de}{service} à {ville}, avec la même exigence de qualité et de transparence que sur l'ensemble de notre secteur d'intervention dans le Val-d'Oise. Une visite technique gratuite permet d'évaluer précisément votre projet avant tout devis, sans surprise sur le prix une fois les travaux lancés. Nos équipes connaissent bien le bâti de la commune, ce qui facilite l'anticipation des contraintes techniques propres aux logements de {ville}.",
            "À {ville}, notre équipe intervient pour des projets {$de}{service}, du premier échange jusqu'à la réception du chantier, avec un devis gratuit et sans engagement. Un interlocuteur unique suit votre dossier de bout en bout, ce qui évite les allers-retours entre plusieurs artisans et garantit une meilleure maîtrise des délais. Comme sur l'ensemble de nos chantiers, les travaux sont couverts par notre garantie décennale et notre assurance responsabilité civile professionnelle.",
            "Basée à Argenteuil, l'équipe CONFOR'INO se déplace régulièrement à {ville} pour des chantiers {$de}{service}, en s'adaptant aux spécificités du bâti local. Chaque intervention démarre par une étude sur mesure de votre logement plutôt qu'une solution standardisée, afin de tenir compte de la configuration réelle des lieux. Le devis détaillé vous est transmis rapidement après la visite technique, sans frais ni engagement de votre part.",
        ];

        $template = $templates[crc32($cityName) % count($templates)];

        return strtr($template, [
            '{service}' => $service,
            '{ville}' => $cityName,
        ]);
    }
}
