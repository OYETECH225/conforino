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
        // Bandeau de confiance générique, affiché sur toutes les fiches
        // prestation (reprend les chiffres déjà utilisés ailleurs sur le site :
        // page Réalisations, pied de page).
        $whyConforinoBlock = ['type' => 'stats', 'data' => [
            'heading' => "Pourquoi CONFOR'INO",
            'items' => [
                ['value' => '13 ans', 'label' => "d'expérience en rénovation et agencement"],
                ['value' => '200+', 'label' => 'projets et clients accompagnés'],
                ['value' => 'Décennale', 'label' => 'garantie & RC professionnelle'],
            ],
        ]];

        $services = [
            [
                'title' => 'Douche sécurisée & salle de bain PMR',
                'slug' => 'amenagement-pmr',
                'icon' => 'pmr',
                'short_description' => "Nous adaptons votre salle de bain pour améliorer le confort, l'accessibilité et la sécurité : douche accessible, barres d'appui, siège de douche et équipements adaptés.",
                'breadcrumb_badges' => [
                    ['icon' => 'check', 'text' => 'Devis gratuit & sans engagement'],
                    ['icon' => 'shield', 'text' => 'Garantie décennale Groupama', 'solid' => true],
                ],
                'blocks' => [
                    $whyConforinoBlock,
                    ['type' => 'pmr_norms', 'data' => [
                        'eyebrow' => 'Repères réglementaires',
                        'heading' => "Les normes d'accessibilité PMR, en pratique",
                        'intro' => "Les aménagements PMR répondent à des règles précises de dimensionnement, pensées pour un usage sûr et autonome en fauteuil roulant ou en déambulateur.",
                        'items' => [
                            ['diagram' => 'giration', 'value' => '⌀ 1,50 m', 'label' => "Zone de giration minimale pour la rotation d'un fauteuil roulant"],
                            ['diagram' => 'passage', 'value' => '0,90 m', 'label' => "Largeur de passage minimale (porte, couloir d'accès)"],
                        ],
                    ]],
                    ['type' => 'comparison_table', 'data' => [
                        'eyebrow' => 'Faire le bon choix',
                        'heading' => 'Douche PMR, douche classique ou baignoire ?',
                        'intro' => 'Un comparatif simple pour visualiser ce que change une douche sécurisée au quotidien.',
                        'column_1' => 'Douche PMR sécurisée',
                        'column_2' => 'Douche classique',
                        'column_3' => 'Baignoire classique',
                        'rows' => [
                            ['label' => 'Seuil à franchir', 'value_1' => '0 mm (plain-pied)', 'value_2' => '15 à 20 cm', 'value_3' => '40 à 60 cm à enjamber'],
                            ['label' => 'Giration fauteuil roulant', 'value_1' => 'Compatible (1,50 m)', 'value_2' => 'Non prévue', 'value_3' => 'Non prévue'],
                            ['label' => 'Risque de glissade', 'value_1' => 'Réduit (receveur antidérapant)', 'value_2' => 'Standard', 'value_3' => 'Élevé (enjambement)'],
                            ['label' => "Barres d'appui", 'value_1' => 'Intégrées dès la conception', 'value_2' => 'Rarement prévues', 'value_3' => 'Difficiles à fixer'],
                            ['label' => 'Entretien au quotidien', 'value_1' => 'Simple (grand receveur plat)', 'value_2' => 'Standard', 'value_3' => 'Plus contraignant'],
                        ],
                    ]],
                ],
                'long_description' => "<p>Vieillissement, perte de mobilité, handicap ou simple souci de sécurité au quotidien : la douche sécurisée et la salle de bain PMR (personnes à mobilité réduite) consistent à adapter un logement existant pour qu'il reste sûr et confortable, sans attendre un accident. CONFOR'INO intervient à Argenteuil et dans tout le Val-d'Oise pour transformer une salle de bain ou un logement standard en espace accessible, sans le rendre médicalisé pour autant.</p>"
                    ."<p>Notre prestation la plus demandée reste le remplacement d'une baignoire par une douche à l'italienne de plain-pied, avec receveur extra-plat, siège de douche rabattable, barres d'appui positionnées selon vos besoins réels (et non un standard générique), et robinetterie thermostatique facile à manipuler. Nous posons également des mains courantes et rampes d'accès sur mesure pour sécuriser un escalier ou une entrée, ainsi que des dalles et clous podotactiles répondant aux normes d'accessibilité pour les personnes malvoyantes.</p>"
                    ."<p>Chaque projet démarre par une visite technique gratuite à votre domicile : nous observons la configuration réelle du logement (largeur des portes, dénivelés, réseaux existants) avant de proposer des solutions concrètes plutôt qu'un catalogue standard. Les travaux sont ensuite coordonnés par un interlocuteur unique, du premier rendez-vous à la réception de chantier.</p>"
                    ."<ul><li>Douches sécurisées et receveurs extra-plats</li><li>Barres d'appui et mains courantes sur mesure</li><li>Rampes d'accès et suppression des seuils</li><li>Dalles et clous podotactiles</li><li>Devis gratuit après visite technique</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale (Groupama).</p>",
            ],
            [
                'title' => 'Rénovation salle de bain et cuisine',
                'slug' => 'renovation-salle-de-bain-cuisine',
                'icon' => 'bathroom',
                'short_description' => 'Nous concevons et rénovons des salles de bain et cuisine fonctionnelles, durables et adaptées à vos besoins, à votre espace et à votre budget.',
                'breadcrumb_badges' => [
                    ['icon' => 'check', 'text' => 'Devis gratuit & sans engagement'],
                    ['icon' => 'shield', 'text' => 'Garantie décennale Groupama', 'solid' => true],
                ],
                'blocks' => [
                    $whyConforinoBlock,
                ],
                'long_description' => "<p>Qu'il s'agisse d'une cuisine ou d'une salle de bain, CONFOR'INO conçoit et rénove ces pièces du quotidien à Argenteuil et dans le Val-d'Oise en partant systématiquement d'une étude de votre espace et de vos usages réels, plutôt que d'un catalogue de modèles standards.</p>"
                    ."<p>Pour une cuisine : conception personnalisée avec plans 3D pour visualiser l'agencement avant tout achat (implantation en L, en U, en îlot ou cuisine ouverte sur le séjour), optimisation du triangle d'activité (évier, cuisson, réfrigérateur), et choix des matériaux (façades, plan de travail, crédence) adaptés à votre budget.</p>"
                    ."<p>Pour une salle de bain : remplacement de baignoire par une douche à l'italienne avec receveur extra-plat, pose de meubles vasque et de faïence en grand format, et traitement soigné de l'étanchéité — un point souvent négligé qui conditionne pourtant la durabilité du chantier. Nous travaillons aussi bien sur une rénovation complète que sur des interventions ciblées : remplacement d'une paroi de douche, pose d'un meuble, changement de robinetterie.</p>"
                    ."<p>Dans les deux cas, nous coordonnons l'ensemble des corps de métier (dépose de l'existant, plomberie, électricité, pose des meubles et de l'électroménager, raccordements, finitions), avec un interlocuteur unique qui suit votre chantier du premier échange à la réception des travaux — sans multiplier les intervenants ni les surprises de dernière minute.</p>"
                    ."<ul><li>Conception et plans 3D personnalisés (cuisine)</li><li>Douche à l'italienne, meubles et faïence (salle de bain)</li><li>Plomberie, électricité et étanchéité</li><li>Choix des matériaux selon votre budget</li><li>Devis gratuit et sans engagement</li></ul>"
                    ."<p>Comme pour l'ensemble de nos prestations, les travaux sont couverts par notre assurance responsabilité civile professionnelle et notre garantie décennale.</p>",
            ],
            [
                'title' => 'Rénovation intérieure',
                'slug' => 'renovation-interieure',
                'icon' => 'renovation',
                'short_description' => 'Travaux de rénovation intérieure pour appartements, maisons et locaux professionnels : peinture, revêtements, plomberie, électricité et finitions.',
                'corner_badge_icon' => 'shield',
                'corner_badge_text' => "Tous corps d'état",
                'breadcrumb_badges' => [
                    ['icon' => 'shield', 'text' => 'Garantie décennale Groupama'],
                    ['icon' => 'handshake', 'text' => "Maîtrise d'œuvre totale", 'solid' => true],
                ],
                'blocks' => [
                    $whyConforinoBlock,
                    ['type' => 'feature_grid', 'data' => [
                        'eyebrow' => 'Maîtrise technique directe',
                        'heading' => 'Nos corps de métier maîtrisés en interne',
                        'intro' => "Une synergie d'artisans expérimentés pour un chantier fluide, sans dispersion de responsabilités.",
                        'items' => [
                            ['icon' => 'renovation', 'title' => 'Démolition & gros œuvre léger', 'text' => "Ouverture ou dépose de cloisons, préparation du chantier avant reprise des autres corps de métier."],
                            ['icon' => 'electricity', 'title' => 'Électricité & mise aux normes', 'text' => 'Tableau électrique, prises, éclairage : mise en conformité complète de votre installation.'],
                            ['icon' => 'plumbing', 'title' => 'Plomberie & sanitaire', 'text' => "Réseaux d'eau et d'évacuation, installation et raccordement des équipements sanitaires."],
                            ['icon' => 'partition', 'title' => 'Plâtrerie & cloisons', 'text' => "Création de cloisons et aménagement d'espaces pour reconfigurer ou optimiser une pièce."],
                            ['icon' => 'ruler', 'title' => 'Revêtements sols & murs', 'text' => 'Reprise des sols, plinthes et encadrements de menuiserie avant finitions.'],
                            ['icon' => 'painting', 'title' => 'Peinture & finitions', 'text' => 'Traitement des murs et plafonds, finitions soignées avant réception du chantier.'],
                        ],
                    ]],
                    ['type' => 'process', 'data' => [
                        'eyebrow' => "Protocole d'exécution",
                        'heading' => "Comment CONFOR'INO pilote votre chantier",
                        'steps' => [
                            ['icon' => 'ruler', 'title' => 'Visite technique', 'description' => 'Déplacement sur place pour relever les contraintes du logement et cadrer précisément le périmètre des travaux.', 'proof' => 'Visite gratuite'],
                            ['icon' => 'quote', 'title' => 'Devis détaillé par poste', 'description' => 'Un chiffrage clair, poste par poste, sans ligne floue ni surprise à la facturation.', 'proof' => 'Devis ferme & gratuit'],
                            ['icon' => 'handshake', 'title' => 'Interlocuteur unique', 'description' => "Un seul interlocuteur coordonne l'ensemble des corps de métier jusqu'à la réception du chantier.", 'proof' => "Points d'étape réguliers"],
                            ['icon' => 'shield', 'title' => 'Réception & garantie', 'description' => 'Contrôle final avant réception, chantier propre et garanties légales applicables.', 'proof' => 'Décennale Groupama'],
                        ],
                    ]],
                ],
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
                    'breadcrumb_badges' => $data['breadcrumb_badges'] ?? null,
                    'corner_badge_icon' => $data['corner_badge_icon'] ?? null,
                    'corner_badge_text' => $data['corner_badge_text'] ?? null,
                    'is_active' => true,
                    'order' => $index,
                    'robots' => 'index,follow',
                ]
            );

            $service->blocks()->delete();

            foreach ($data['blocks'] ?? [] as $blockIndex => $block) {
                $service->blocks()->create([
                    'type' => $block['type'],
                    'data' => $block['data'],
                    'order' => $blockIndex,
                    'is_active' => true,
                ]);
            }

            foreach ($cities as $city) {
                $service->cities()->syncWithoutDetaching([
                    $city->id => [
                        'local_intro' => $this->localIntro($data['title'], $city->name),
                        'is_published' => true,
                    ],
                ]);
            }
        }

        // Fusion de "Agencement cuisine" et "Agencement salle de bain" en un
        // seul service "Rénovation salle de bain et cuisine" ci-dessus : les
        // anciennes fiches n'ont plus lieu d'être. realisations.service_id est
        // en nullOnDelete, donc cette suppression est sans risque même avant
        // RealMediaSeeder (qui exécuté après) : il réassigne de toute façon
        // chaque réalisation au nouveau slug à chaque reseed.
        Service::query()->whereIn('slug', ['agencement-cuisine', 'agencement-salle-de-bain'])
            ->get()
            ->each(function (Service $old) {
                $old->blocks()->delete();
                $old->delete();
            });
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
