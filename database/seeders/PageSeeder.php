<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Page;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Recrée les pages du CMS à partir du contenu de l'ancien site conforino.fr,
 * en corrigeant au passage les problèmes relevés lors de l'audit SEO :
 * - un seul H1 par page (porté par le bloc hero)
 * - hiérarchie Hn propre (H1 > H2 > H3) au lieu de la structure à plat de
 *   l'ancienne page PMR
 * - FAQ homepage : villes desservies listées précisément au lieu de
 *   "Val-d'Oise et communes voisines"
 */
class PageSeeder extends Seeder
{
    public function run(): void
    {
        $cityNames = City::query()->active()->ordered()->pluck('name')->all();
        $cityList = $this->humanList($cityNames);

        $this->page('accueil', 'Accueil', 'index,follow', 'LocalBusiness', [
            $this->block('hero', [
                'eyebrow' => "Rénovation architecturale & adaptation PMR • Argenteuil (95)",
                'heading' => "CONFOR'INO réalise vos projets de salle de bain, de douche sécurisée et d'adaptation PMR",
                'subheading' => "Entreprise de rénovation basée à Argenteuil, nous accompagnons particuliers et professionnels dans leurs projets de salle de bain, d'adaptation PMR et de rénovation intérieure — un accompagnement attentif, du premier échange aux dernières finitions.",
                'image' => $this->seedImage('hero-homepage.webp'),
                'proof_line' => 'Sans engagement · Réponse sous 24-48h · Diagnostic sur place gratuit',
                'cta_label' => 'Recevoir mon devis gratuit',
                'cta_url' => '/contact',
                'cta2_label' => 'Découvrir nos réalisations',
                'cta2_url' => '/realisations',
                'strip_icon' => 'pmr',
                'strip_text' => 'Douche de plain-pied sans seuil · Receveur extra-plat',
                'strip_badge' => 'Accessibilité PMR',
            ]),
            $this->block('process', [
                'eyebrow' => 'Savoir-faire architectural',
                'heading' => 'Notre méthode',
                'steps' => [
                    [
                        'icon' => 'ruler',
                        'title' => 'Étude personnalisée',
                        'description' => "Analyse technique rigoureuse à domicile, relevé des contraintes d'accessibilité PMR, écoute des habitudes de vie et modélisation sur mesure adaptée à votre budget.",
                        'proof' => "Visite d'évaluation sous 48h",
                    ],
                    [
                        'icon' => 'handshake',
                        'title' => 'Projet clé en main',
                        'description' => "Un interlocuteur unique de la conception à la réception du chantier. Prise en charge intégrale : démolition, plomberie sanitaire, carrelage antidérapant, électricité et finitions soignées.",
                        'proof' => 'Zéro sous-traitance non déclarée',
                    ],
                    [
                        'icon' => 'pmr',
                        'title' => 'Confort & autonomie',
                        'description' => 'Conception ergonomique sans compromis esthétique. Équipements certifiés, barres de maintien design intégrées, seuil zéro et valorisation durable de votre habitat.',
                        'proof' => 'Confort et sécurité durables',
                    ],
                ],
                'trust_items' => [
                    ['icon' => 'check', 'text' => 'Devis gratuit & détaillé sans surprise'],
                    ['icon' => 'clock', 'text' => 'Réponse garantie sous 24h à 48h'],
                    ['icon' => 'pin', 'text' => 'Entreprise locale basée à Argenteuil (95)'],
                    ['icon' => 'shield', 'text' => 'Assurance RC Pro & Garantie décennale'],
                ],
            ]),
            $this->block('services_grid', [
                'eyebrow' => 'Savoir-faire architectural',
                'heading' => 'Nos expertises métier',
                'intro' => "De l'aménagement spécialisé d'espaces de bain sécurisés aux réhabilitations complètes, nous allions technique exigeante et élégance d'agencement.",
                'items' => [
                    [
                        'is_info_card' => true,
                        'icon' => 'plumbing',
                        'title' => 'Plomberie & Installation Sanitaire',
                        'info_label' => 'Prix fixes, à la demande',
                        'info_value' => 'Robinetterie, WC, receveur…',
                        'summary' => "Installation, remplacement et dépannage de vos équipements sanitaires à Argenteuil et dans le Val-d'Oise.",
                        'url' => '/installation-sanitaire',
                    ],
                    ['icon' => 'bathroom', 'title' => 'Rénovation Salle de Bain & Cuisine', 'tag' => 'Agencement Sur Mesure', 'image' => $this->seedImage('salle-de-bain-1.jpg'), 'summary' => 'Nous concevons et rénovons des salles de bain et cuisine fonctionnelles, durables et adaptées à vos besoins, à votre espace et à votre budget.', 'url' => '/services/renovation-salle-de-bain-cuisine'],
                    ['icon' => 'pmr', 'title' => 'Douche Sécurisée & Salle de Bain PMR', 'tag' => 'PMR & Autonomie', 'image' => $this->seedImage('pmr-1.jpg'), 'summary' => "Nous adaptons votre salle de bain pour améliorer le confort, l'accessibilité et la sécurité : douche accessible, barres d'appui, siège de douche et équipements adaptés.", 'url' => '/services/amenagement-pmr'],
                    [
                        'is_info_card' => true,
                        'icon' => 'shield',
                        'title' => 'Rénovation Intérieure Générale',
                        'info_label' => "Tous corps d'état",
                        'info_value' => 'Plomberie, électricité, peinture',
                        'summary' => 'Reprise complète plomberie, électricité aux normes, peintures écologiques dépolluantes, réfection des sols et menuiseries sur mesure.',
                        'url' => '/services/renovation-interieure',
                    ],
                ],
            ]),
            $this->block('stats', [
                'eyebrow' => 'Artisanat engagé & proximité',
                'heading' => 'Une approche humaine et rigoureuse au service de votre sérénité.',
                'intro' => "Installée au cœur d'Argenteuil, l'entreprise CONFOR'INO est née d'une conviction fondamentale : l'adaptation du domicile pour les personnes fragilisées et les aînés ne doit jamais ressembler à une hospitalisation. Nous concevons des pièces de vie sécurisées, ergonomiques et chaleureuses qui valorisent votre bien.\n\nNous accompagnons personnellement les familles et les aidants à chaque étape, en éliminant les intermédiaires superflus et en refusant catégoriquement les prestations standardisées sans âme.",
                'proof_items' => ['Qualité artisanale', 'Assuré Groupama', 'Délais tenus'],
                'items' => [
                    ['value' => '200+', 'label' => "Projets et familles accompagnés dans le Val-d'Oise", 'description' => 'Argenteuil, Cormeilles, Sannois, Cergy et communes limitrophes.'],
                    ['value' => '13 ans', 'label' => "D'expérience métier & d'exigence artisanale", 'description' => 'Expertise certifiée en plomberie sanitaire, étanchéité et mise en accessibilité.'],
                ],
            ]),
            $this->block('gallery_preview', ['eyebrow' => 'Galerie chantier', 'heading' => 'Nos réalisations récentes', 'count' => 4]),
            $this->block('testimonials', [
                'eyebrow' => 'Témoignages vérifiés',
                'heading' => 'La confiance de nos clients et de leurs familles',
                'review_ids' => Review::query()->published()->pluck('id')->all(),
            ]),
            $this->block('service_areas', [
                'heading' => "Zones d'intervention",
                'intro' => "Nous intervenons principalement dans le Val-d'Oise et les communes voisines suivantes :",
                'city_ids' => City::query()->active()->pluck('id')->all(),
            ]),
            $this->block('faq', [
                'eyebrow' => 'Réponses claires',
                'heading' => 'Questions fréquentes',
                'items' => [
                    ['question' => 'Réalisez-vous des salles de bain PMR et douches sécurisées ?', 'answer' => "<p>Oui. CONFOR'INO réalise l'adaptation de salles de bain PMR, l'installation de douches sécurisées, la pose de barres d'appui et le remplacement de baignoires par des douches accessibles.</p>"],
                    ['question' => 'Le devis de rénovation est-il gratuit ?', 'answer' => '<p>Oui. Chaque projet fait l\'objet d\'une première étude et d\'un devis gratuit, sans engagement. Une visite technique peut être nécessaire pour confirmer la faisabilité et le prix.</p>'],
                    ['question' => 'Dans quelles villes intervenez-vous ?', 'answer' => "<p>Nous intervenons à {$cityList}, ainsi que dans les autres communes du Val-d'Oise sur demande.</p>"],
                    ['question' => 'Les travaux sont-ils couverts par une garantie ?', 'answer' => '<p>Oui. Nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale (Groupama).</p>'],
                ],
            ]),
            $this->block('contact_form', [
                'eyebrow' => 'Devis rapide & gratuit',
                'heading' => 'Parlez-nous de votre projet de rénovation ou d\'adaptation',
                'intro' => "Recevez une première estimation détaillée sous 24h à 48h ouvrées. Un technicien peut se déplacer chez vous à Argenteuil ou dans le 95 sans aucun frais.",
            ]),
        ]);

        // Page de destination pour les campagnes Google Ads : gabarit "landing"
        // (sans menu ni pied de page complets, cf. x-landing-layout), noindex
        // pour ne pas entrer en concurrence SEO avec les pages du site, et
        // contenu assemblé à partir des mêmes blocs/chiffres/avis déjà utilisés
        // ailleurs sur le site (aucune donnée inventée pour l'occasion).
        $featuredReviewIds = Review::query()->published()->featured()->ordered()->limit(3)->pluck('id')->all();

        $this->page('devis-gratuit-argenteuil', 'Devis gratuit — Rénovation, PMR, cuisine & salle de bain', 'noindex,follow', 'WebPage', [
            $this->block('hero', [
                'eyebrow' => 'Offre réservée aux demandes en ligne',
                'heading' => 'Devis gratuit pour vos travaux à Argenteuil et dans le Val-d\'Oise',
                'subheading' => "Salle de bain, cuisine, aménagement PMR ou rénovation complète : recevez une étude personnalisée et un devis gratuit, sans engagement.",
                'image' => $this->seedImage('hero-homepage.webp'),
                'proof_line' => 'Sans engagement · Réponse sous 24-48h · Diagnostic sur place gratuit',
                'cta_label' => 'Recevoir mon devis gratuit',
                'cta_url' => '#devis',
            ]),
            $this->block('contact_form', [
                'eyebrow' => 'Étude gratuite & sans engagement',
                'heading' => 'Demandez votre devis gratuit',
                'intro' => "Un interlocuteur unique vous recontacte rapidement pour qualifier votre projet et convenir d'une visite technique si nécessaire.",
            ]),
            $this->block('stats', [
                'heading' => "Pourquoi CONFOR'INO",
                'items' => [
                    ['value' => '13 ans', 'label' => "d'expérience en rénovation et agencement"],
                    ['value' => '200+', 'label' => 'projets et clients accompagnés'],
                    ['value' => 'Décennale', 'label' => 'garantie & RC professionnelle'],
                ],
            ]),
            $this->block('testimonials', [
                'eyebrow' => 'Avis clients',
                'heading' => 'Ce que disent nos clients du Val-d\'Oise',
                'review_ids' => $featuredReviewIds,
            ]),
            $this->block('faq', [
                'eyebrow' => 'Réponses claires',
                'heading' => 'Vos questions avant de nous contacter',
                'items' => [
                    ['question' => 'Réalisez-vous des salles de bain PMR et douches sécurisées ?', 'answer' => "<p>Oui. CONFOR'INO réalise l'adaptation de salles de bain PMR, l'installation de douches sécurisées, la pose de barres d'appui et le remplacement de baignoires par des douches accessibles.</p>"],
                    ['question' => 'Le devis de rénovation est-il gratuit ?', 'answer' => '<p>Oui. Chaque projet fait l\'objet d\'une première étude et d\'un devis gratuit, sans engagement. Une visite technique peut être nécessaire pour confirmer la faisabilité et le prix.</p>'],
                    ['question' => 'Dans quelles villes intervenez-vous ?', 'answer' => "<p>Nous intervenons à {$cityList}, ainsi que dans les autres communes du Val-d'Oise sur demande.</p>"],
                    ['question' => 'Les travaux sont-ils couverts par une garantie ?', 'answer' => '<p>Oui. Nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale (Groupama).</p>'],
                ],
            ]),
        ], showBreadcrumb: false, template: 'landing');

        // Page hidden content for the "Plomberie & installation sanitaire"
        // section (reprise de l'ancienne page /installation-sanitaire-val-doise/
        // ajoutée par le client) : hero, bénéfices et étapes, gérés comme une
        // Page CMS cachée au même titre que "realisations" ci-dessus, pour
        // rester éditables ; la grille de prestations elle-même et leurs prix
        // viennent de SanitaryServiceSeeder.
        $this->page('installation-sanitaire', 'Plomberie & installation sanitaire (hero & bénéfices)', 'noindex,nofollow', 'WebPage', [
            $this->block('hero', [
                'eyebrow' => 'Prix connus à l\'avance',
                'heading' => 'Plomberie & installation sanitaire',
                'subheading' => "Installation de robinetterie, éviers, WC, receveurs de douche et équipements de confort à domicile dans le Val-d'Oise : des prestations à prix fixe, réalisées par un professionnel qualifié.",
            ]),
            $this->block('feature_grid', [
                'eyebrow' => 'Pourquoi choisir notre service de pose ?',
                'heading' => 'Des interventions simples, sans surprise',
                'items' => [
                    ['icon' => 'check', 'title' => 'Prix connus à l\'avance', 'text' => 'Chaque prestation est affichée avec un tarif TTC clair, avant toute intervention.'],
                    ['icon' => 'pin', 'title' => 'Déplacement inclus', 'text' => 'Le déplacement est inclus dans notre zone habituelle d\'intervention.'],
                    ['icon' => 'handshake', 'title' => 'Professionnel qualifié', 'text' => 'Intervention réalisée dans le respect des règles de l\'art et des normes en vigueur.'],
                    ['icon' => 'shield', 'title' => 'Aucun supplément surprise', 'text' => 'Aucune prestation complémentaire n\'est réalisée sans information préalable ni accord du client.'],
                    ['icon' => 'star', 'title' => 'Assurances professionnelles', 'text' => 'Responsabilité civile professionnelle et garantie décennale souscrites auprès de Groupama.'],
                    ['icon' => 'clock', 'title' => 'Réservation simple et rapide', 'text' => 'Une demande en ligne suffit : nous vous recontactons pour confirmer le rendez-vous.'],
                ],
            ]),
            $this->block('process', [
                'eyebrow' => 'Comment ça fonctionne',
                'heading' => 'De la demande à la facture',
                'steps' => [
                    ['icon' => 'quote', 'title' => 'Choisissez votre prestation', 'description' => 'Sélectionnez la prestation correspondant à votre besoin parmi notre liste à prix fixe.'],
                    ['icon' => 'ruler', 'title' => 'Complétez votre demande d\'intervention', 'description' => 'Remplissez le formulaire en ligne avec vos coordonnées et les détails utiles.'],
                    ['icon' => 'phone', 'title' => 'Nous vous contactons', 'description' => 'Un interlocuteur vous recontacte pour confirmer le rendez-vous.'],
                    ['icon' => 'handshake', 'title' => 'Le technicien intervient à votre domicile', 'description' => 'L\'intervention est réalisée au tarif annoncé, sans supplément sans votre accord.'],
                    ['icon' => 'check', 'title' => 'Vous recevez votre facture', 'description' => 'La facture vous est transmise à l\'issue de l\'intervention.'],
                ],
            ]),
        ], showBreadcrumb: false);

        $this->page('services', 'Services', 'index,follow', 'WebPage', [
            $this->block('hero', [
                'heading' => 'Nos prestations de rénovation et d\'aménagement',
                'subheading' => "Plomberie & installation sanitaire, rénovation salle de bain et cuisine, douche sécurisée PMR et rénovation intérieure : découvrez l'ensemble de nos savoir-faire.",
            ]),
            $this->block('services_grid', [
                'items' => [
                    [
                        'is_info_card' => true,
                        'icon' => 'plumbing',
                        'title' => 'Plomberie & installation sanitaire',
                        'info_label' => 'Prix fixes, à la demande',
                        'info_value' => 'Robinetterie, WC, receveur…',
                        'summary' => "Installation, remplacement et dépannage de vos équipements sanitaires.",
                        'url' => '/installation-sanitaire',
                    ],
                    ['icon' => 'bathroom', 'title' => 'Rénovation salle de bain et cuisine', 'tag' => 'Agencement Sur Mesure', 'image' => $this->seedImage('salle-de-bain-2.jpg'), 'summary' => 'Salles de bain et cuisines fonctionnelles, durables et adaptées à votre budget.', 'url' => '/services/renovation-salle-de-bain-cuisine'],
                    ['icon' => 'pmr', 'title' => 'Douche sécurisée & salle de bain PMR', 'tag' => 'PMR & Autonomie', 'image' => $this->seedImage('pmr-2.jpg'), 'summary' => "Douches sécurisées, barres d'appui, accessibilité.", 'url' => '/services/amenagement-pmr'],
                    [
                        'is_info_card' => true,
                        'icon' => 'shield',
                        'title' => 'Rénovation Intérieure',
                        'info_label' => "Tous corps d'état",
                        'info_value' => 'Plomberie, électricité, peinture',
                        'summary' => 'Plomberie, électricité, peinture, cloisons.',
                        'url' => '/services/renovation-interieure',
                    ],
                ],
            ]),
            $this->block('rich_text', [
                'content' => "<h2>Une entreprise, quatre expertises complémentaires</h2>"
                    ."<p>CONFOR'INO intervient à Argenteuil et dans tout le Val-d'Oise sur quatre types de projets : la plomberie et l'installation sanitaire (prestations à prix fixe), la rénovation de salle de bain et de cuisine, la douche sécurisée et la salle de bain PMR (accessibilité et sécurité à domicile), et la rénovation intérieure au sens large (plomberie, électricité, peinture, cloisons). Ces quatre prestations se recoupent souvent sur un même chantier — une salle de bain PMR implique par exemple de la plomberie et parfois de l'électricité — ce qui nous permet de proposer un devis unique et un seul interlocuteur, même lorsque plusieurs corps de métier interviennent.</p>"
                    ."<h2>Une méthode identique quel que soit le projet</h2>"
                    ."<p>Quelle que soit la prestation, notre démarche reste la même : une étude sur mesure de votre logement (et non un modèle standardisé), un devis détaillé et gratuit sans engagement, puis un chantier coordonné par un interlocuteur unique jusqu'à la réception des travaux. Cette organisation évite les intermédiaires multiples et les mauvaises surprises sur les délais ou le budget.</p>"
                    ."<p>Toutes nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale souscrites auprès de Groupama. Vous pouvez consulter le détail de chaque prestation ci-dessous, ou nous contacter directement pour un premier échange sur votre projet.</p>",
            ]),
        ]);

        $this->page('a-propos', 'À propos', 'index,follow', 'WebPage', [
            $this->block('hero', [
                'heading' => "À propos de CONFOR'INO",
                'subheading' => 'Un accompagnement attentif, du premier échange aux dernières finitions.',
                'image' => $this->seedImage('renovation-1.jpeg'),
                'cta_label' => 'Recevoir mon devis gratuit',
                'cta_url' => '/contact',
            ]),
            $this->block('rich_text', [
                'content' => "<p>Entreprise de rénovation basée à Argenteuil, CONFOR'INO accompagne les particuliers et les professionnels dans leurs projets de salle de bain, d'adaptation PMR et de rénovation intérieure.</p>"
                    ."<p>Chaque chantier commence par une étude de vos besoins, de votre logement et de vos contraintes. Un interlocuteur suit votre projet, coordonne les travaux et reste disponible jusqu'à la livraison.</p>"
                    ."<p>Notre objectif est de vous proposer une solution claire, réaliste et durable, avec des travaux couverts par une assurance responsabilité civile professionnelle et une garantie décennale.</p>",
            ]),
            $this->block('stats', [
                'eyebrow' => 'Artisanat engagé & proximité',
                'heading' => 'En quelques chiffres',
                'items' => [
                    ['value' => '13 ans', 'label' => "d'expérience métier dans la rénovation et l'aménagement"],
                    ['value' => '200+', 'label' => 'projets et clients accompagnés'],
                    ['value' => 'Décennale', 'label' => 'garantie sur tous nos chantiers'],
                    ['value' => 'RC Pro', 'label' => 'assurance responsabilité civile professionnelle'],
                ],
            ]),
            $this->block('service_areas', [
                'heading' => "Zones d'intervention",
                'intro' => "Nous intervenons principalement à Argenteuil et dans les communes voisines du Val-d'Oise :",
                'city_ids' => City::query()->active()->pluck('id')->all(),
            ]),
            $this->block('contact_form', [
                'heading' => 'Parlons de votre projet',
                'intro' => 'Réponse sous 48h ouvrées, sans engagement.',
            ]),
        ]);

        $this->page('faq', 'FAQ', 'index,follow', 'FAQPage', [
            $this->block('hero', [
                'eyebrow' => "Répertoire d'expertise & normes",
                'heading' => 'Foire aux questions : toutes les réponses à vos projets de rénovation et d\'adaptation PMR',
                'subheading' => "Le déroulement de nos chantiers dans le Val-d'Oise (95), nos normes d'accessibilité et nos engagements déontologiques.",
            ]),
            $this->block('faq', [
                'eyebrow' => 'Réponses claires',
                'heading' => 'Questions fréquentes',
                'searchable' => true,
                'groups' => [
                    [
                        'heading' => 'Accessibilité, ergonomie & normes PMR',
                        'badge' => 'Sécurité & confort',
                        'icon' => 'pmr',
                        'items' => [
                            ['question' => "Qu'est-ce qu'une douche à l'italienne accessible PMR « sans seuil » ?", 'answer' => "<p>Contrairement à un receveur classique, un receveur extra-plat installé de plain-pied supprime le ressaut à l'entrée de la douche. Associé à un revêtement antidérapant et à une évacuation efficace, cet aménagement permet une entrée fluide et autonome au quotidien, pour une personne en déambulateur comme en fauteuil roulant.</p>"],
                            ['question' => 'Comment concilier sécurité PMR et élégance sans effet médicalisé ?', 'answer' => "<p>Nous concevons des pièces de vie sécurisées, ergonomiques et chaleureuses qui valorisent votre logement plutôt que de lui donner un aspect d'établissement de soin. Barres d'appui design, mobilier à hauteur adaptée et finitions soignées font partie intégrante de chaque projet.</p>"],
                            ['question' => 'Les adaptations conviennent-elles aussi bien aux personnes en fauteuil qu\'aux seniors autonomes ?', 'answer' => "<p>Oui. Chaque aménagement est étudié selon les besoins réels de la personne et non sur un standard générique : hauteur d'assise, largeur de passage, emplacement des barres d'appui sont adaptés cas par cas lors de la visite technique.</p>"],
                        ],
                    ],
                    [
                        'heading' => 'Devis, tarification & déontologie',
                        'badge' => 'Zéro démarchage abusif',
                        'icon' => 'shield',
                        'items' => [
                            ['question' => 'La visite technique et le devis sont-ils gratuits ?', 'answer' => '<p>Oui. Chaque projet fait l\'objet d\'une première étude et d\'un devis gratuit, sans engagement. Une visite technique peut être nécessaire pour confirmer la faisabilité et le prix.</p>'],
                            ['question' => 'Le montant du devis peut-il être augmenté en cours de chantier ?', 'answer' => '<p>Non. Le devis signé est ferme. Toute modification du périmètre des travaux demandée en cours de chantier fait l\'objet d\'un avenant écrit, jamais d\'un ajout de facturation unilatéral.</p>'],
                            ['question' => 'Quelle est votre politique en matière de démarchage téléphonique ?', 'answer' => "<p>Conformément à la réglementation encadrant le démarchage, CONFOR'INO ne procède à aucune prospection commerciale non sollicitée et recueille un consentement explicite et préalable avant toute prise de contact commerciale.</p>"],
                        ],
                    ],
                    [
                        'heading' => 'Déroulement du chantier, propreté & délais',
                        'badge' => 'Chantier coordonné',
                        'icon' => 'clock',
                        'items' => [
                            ['question' => 'Combien de temps dure un chantier de salle de bain ou de douche sécurisée ?', 'answer' => '<p>La durée dépend de l\'ampleur des travaux (dépose, plomberie, carrelage, finitions). Un calendrier précis vous est communiqué avec le devis, avec des points d\'étape réguliers plutôt qu\'un chantier qui s\'éternise sans visibilité.</p>'],
                            ['question' => 'Comment protégez-vous mon logement et les parties communes pendant les travaux ?', 'answer' => '<p>Protection des sols et accès, évacuation régulière des gravats et nettoyage du chantier font partie de notre méthode de travail, du premier jour à la réception.</p>'],
                            ['question' => 'Vos artisans intervenants sont-ils des sous-traitants inconnus ?', 'answer' => "<p>Non. Nous refusons catégoriquement la sous-traitance non déclarée : les artisans qui interviennent chez vous sont ceux que nous mandatons directement, avec un interlocuteur unique pour tout le chantier.</p>"],
                        ],
                    ],
                    [
                        'heading' => "Garantie décennale & secteur d'intervention",
                        'badge' => "Val-d'Oise & alentours",
                        'icon' => 'pin',
                        'items' => [
                            ['question' => 'Quelles sont les garanties et assurances qui couvrent mes travaux ?', 'answer' => '<p>Nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale souscrites auprès de Groupama.</p>'],
                            ['question' => 'Dans quelles communes intervenez-vous ?', 'answer' => "<p>Nous sommes basés à Argenteuil (95) et intervenons principalement à {$cityList}, ainsi que dans les autres communes du Val-d'Oise sur demande.</p>"],
                            ['question' => 'Que se passe-t-il en cas de souci après la réception des travaux ?', 'answer' => '<p>Les garanties légales de parfait achèvement et de bon fonctionnement s\'appliquent conformément à la loi, en complément de notre garantie décennale. Contactez-nous, nous qualifions la demande rapidement.</p>'],
                        ],
                    ],
                ],
            ]),
            $this->block('contact_form', [
                'eyebrow' => 'Formulaire technique',
                'heading' => 'Posez votre question à notre équipe',
                'intro' => 'Décrivez votre projet ou votre question, un technicien vous répond sous 24h ouvrées.',
            ]),
        ]);

        $this->page('contact', 'Contact / Devis gratuit', 'index,follow', 'WebPage', [
            $this->block('hero', [
                'eyebrow' => 'Écoute & étude sur-mesure',
                'heading' => 'Parlons de votre projet : une écoute humaine, un métré rigoureux sans engagement.',
                'subheading' => "Que ce soit pour une douche PMR sécurisée, une rénovation complète ou un agencement de pièce, nous nous déplaçons chez vous à Argenteuil et dans tout le Val-d'Oise.",
                'proof_line' => 'Visite technique gratuite · Devis ferme · Zéro démarchage commercial',
                'cta_label' => 'Programmer ma visite technique',
                'cta_url' => '#devis',
                'strip_icon' => 'clock',
                'strip_text' => 'Réponse garantie sous 48h ouvrées',
                'strip_badge' => 'Standard 8h-19h',
            ]),
            $this->block('contact_form', [
                'eyebrow' => 'Formulaire d\'étude & rendez-vous',
                'heading' => 'Programmez votre visite technique à domicile',
                'intro' => "Remplissez les 4 étapes ci-dessous. Un technicien CONFOR'INO valide le créneau avec vous par téléphone avant toute venue.",
                'wizard' => true,
            ]),
            $this->block('service_areas', [
                'heading' => "Zone d'intervention",
                'intro' => "Basés à Argenteuil, nous nous déplaçons sans frais dans tout le Val-d'Oise :",
                'city_ids' => City::query()->active()->pluck('id')->all(),
            ]),
        ]);

        // Page "technique", sans route publique dédiée (/realisations est géré par
        // RealisationController) : sert uniquement à rendre éditables depuis l'admin
        // le texte du hero et la charte qualité de la page Réalisations.
        $this->page('realisations', 'Réalisations (hero & charte qualité)', 'noindex,nofollow', 'WebPage', [
            $this->block('hero', [
                'eyebrow' => 'Portfolio technique & études de cas',
                'heading' => "Nos réalisations : l'exigence au service de l'autonomie et du confort",
                'subheading' => "Découvrez nos chantiers de rénovation complète, d'adaptation PMR sécurisée et d'agencement sur mesure réalisés à Argenteuil et dans tout le Val-d'Oise.",
                'cta_label' => 'Demander mon étude gratuite',
                'cta_url' => '#devis',
                'cta2_label' => 'Voir les chantiers',
                'cta2_url' => '#galerie',
            ]),
            $this->block('stats', [
                'items' => [
                    ['value' => '13 ans', 'label' => "d'expérience métier"],
                    ['value' => 'Décennale', 'label' => 'garantie Groupama'],
                    ['value' => '0€', 'label' => 'devis gratuit, sans surprise'],
                ],
            ]),
            $this->block('feature_grid', [
                'eyebrow' => 'Méthodologie & rigueur',
                'heading' => 'La charte de qualité appliquée à chacun de nos chantiers',
                'items' => [
                    ['icon' => 'shield', 'title' => 'Protection du chantier', 'text' => "Sols, escaliers et parties communes protégés avant toute intervention, pour un chantier propre du premier au dernier jour."],
                    ['icon' => 'check', 'title' => 'Propreté & tri des déchets', 'text' => "Évacuation régulière des gravats et tri sélectif, sans stockage prolongé sur la voie publique."],
                    ['icon' => 'handshake', 'title' => 'Interlocuteur dédié', 'text' => 'Un seul interlocuteur suit votre chantier du premier échange à la réception, avec des points réguliers.'],
                    ['icon' => 'shield', 'title' => 'Réception & décennale', 'text' => 'Contrôle final avant réception, chantier propre et garantie décennale Groupama sur les travaux réalisés.'],
                ],
            ]),
        ], showBreadcrumb: false);

        $this->page('mentions-legales', 'Mentions légales', 'index,follow', 'WebPage', [
            $this->block('rich_text', ['content' => $this->mentionsLegalesHtml()]),
        ], showBreadcrumb: true);

        $this->page('politique-de-confidentialite', 'Politique de confidentialité', 'index,follow', 'WebPage', [
            $this->block('rich_text', ['content' => $this->politiqueConfidentialiteHtml()]),
        ]);

        $this->page('protection-du-consommateur', 'Protection du consommateur', 'index,follow', 'WebPage', [
            $this->block('rich_text', ['content' => $this->protectionConsommateurHtml()]),
        ]);

        $this->page('conditions-generales-de-vente', 'Conditions générales de vente', 'index,follow', 'WebPage', [
            $this->block('rich_text', ['content' => $this->cgvHtml()]),
        ]);
    }

    protected function page(string $slug, string $title, string $robots, string $schemaType, array $blocks, bool $showBreadcrumb = true, string $template = 'default'): void
    {
        $page = Page::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'status' => 'published',
                'template' => $template,
                'robots' => $robots,
                'schema_type' => $schemaType,
                'show_breadcrumb' => $showBreadcrumb,
                'published_at' => now(),
            ]
        );

        $page->blocks()->delete();

        foreach ($blocks as $index => $block) {
            $page->blocks()->create([
                'type' => $block['type'],
                'data' => $block['data'],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    protected function block(string $type, array $data): array
    {
        return ['type' => $type, 'data' => $data];
    }

    protected function humanList(array $items): string
    {
        if (count($items) <= 1) {
            return implode('', $items);
        }

        $last = array_pop($items);

        return implode(', ', $items).' et '.$last;
    }

    /**
     * Copie une image d'origine (database/seeders/assets/) vers le disque
     * public et renvoie le chemin relatif attendu par le bloc hero
     * (FileUpload simple, hors médiathèque — voir resources/views/blocks/hero.blade.php).
     */
    protected function seedImage(string $filename): ?string
    {
        $source = database_path('seeders/assets/'.$filename);

        if (! file_exists($source)) {
            return null;
        }

        $target = 'hero/'.$filename;
        Storage::disk('public')->put($target, file_get_contents($source));

        return $target;
    }

    protected function mentionsLegalesHtml(): string
    {
        return <<<'HTML'
        <h2>Éditeur du site</h2>
        <p><strong>CONFOR'INO</strong> — SARL au capital de 1 000 €<br>
        RCS Pontoise : 910 942 267 — TVA intracommunautaire : FR29910942267<br>
        Siège social : 8 rue Yves Farges, 95100 Argenteuil<br>
        Téléphone : 09 72 12 32 36 — Email : contact@conforino.fr<br>
        Responsable de la publication : Salah TALHA, gérant</p>

        <h2>Hébergement</h2>
        <p>OVH SAS — 2 rue Kellermann, 59100 Roubaix, France — Tél. : 1007</p>

        <h2>Assurances professionnelles</h2>
        <p>Responsabilité civile professionnelle et garantie décennale souscrites auprès de
        GROUPAMA PARIS VAL DE LOIRE, 2 avenue de Châteaudun, 41013 Blois.</p>

        <h2>Médiation de la consommation</h2>
        <p>CM2C — Centre de la Médiation de la Consommation, 49 rue de Ponthieu, 75008 Paris —
        www.cm2c.net</p>
        HTML;
    }

    protected function politiqueConfidentialiteHtml(): string
    {
        return <<<'HTML'
        <h2>Responsable du traitement</h2>
        <p>CONFOR'INO, SARL basée à Argenteuil (95), traite les données personnelles des visiteurs
        du site et des clients.</p>

        <h2>Finalités</h2>
        <p>Les données collectées servent à répondre aux demandes de contact et établir des devis,
        exécuter les contrats de prestation, respecter les obligations légales et comptables, et
        sécuriser le site.</p>

        <h2>Données collectées</h2>
        <p>Le formulaire de contact recueille : nom, téléphone, email, description du projet,
        adresse IP et données techniques. Il est demandé aux utilisateurs de ne transmettre aucune
        donnée médicale dans les descriptions.</p>

        <h2>Rappels téléphoniques</h2>
        <p>CONFOR'INO ne rappelle que si la réalité de la demande peut être justifiée, dans un
        délai de cinq jours ouvrables. Les données de rappel sont conservées trois ans.</p>

        <h2>Durées de conservation</h2>
        <ul>
            <li>Demandes non abouties : 3 ans</li>
            <li>Documents comptables : 10 ans</li>
            <li>Données client : durée du contrat + 5 ans d'archivage</li>
            <li>Journaux techniques : 12 mois maximum</li>
        </ul>

        <h2>Cookies et traceurs</h2>
        <p>Lors de votre première visite, un bandeau vous demande d'accepter ou de refuser le dépôt de
        cookies de mesure d'audience. Votre choix est mémorisé dans le stockage local de votre
        navigateur (finalité strictement technique, exemptée de consentement par la CNIL) :</p>
        <ul>
            <li><strong>Mémorisation de votre choix</strong> (stockage local, non soumis à consentement) :
            conservé jusqu'à ce que vous effaciez les données de navigation de votre appareil.</li>
            <li><strong>Mesure d'audience</strong> (Google Analytics et/ou Google Tag Manager) : déposés
            uniquement si vous avez cliqué sur « Accepter », jamais avant et jamais par défaut. Durée de
            conservation : 13 mois maximum, conformément aux recommandations de la CNIL.</li>
        </ul>
        <p>Vous pouvez modifier votre choix à tout moment depuis le lien « Gérer mes cookies » présent en
        bas de chaque page du site.</p>

        <h2>Vos droits</h2>
        <p>Accès, rectification, effacement, limitation, opposition, portabilité. Demandes à
        contact@conforino.fr ou par courrier postal au siège social. Vous pouvez également
        introduire une réclamation auprès de la CNIL, 3 place de Fontenoy, 75007 Paris.</p>
        HTML;
    }

    protected function protectionConsommateurHtml(): string
    {
        return <<<'HTML'
        <h2>Droit de rétractation</h2>
        <p>Pour tout contrat conclu hors établissement ou à distance, vous disposez d'un délai de
        quatorze (14) jours pour exercer votre droit de rétractation, sans avoir à justifier de
        motif. Ce droit ne s'applique pas aux prestations entièrement exécutées avant la fin de ce
        délai, ni aux réparations d'urgence expressément sollicitées par le client.</p>

        <h2>Paiement</h2>
        <p>Aucun versement ne peut être demandé avant l'expiration d'un délai de sept (7) jours
        suivant la signature d'un contrat conclu hors établissement, sauf urgence expressément
        autorisée par le client.</p>

        <h2>Démarchage téléphonique</h2>
        <p>Conformément à la loi du 30 juin 2025 encadrant le démarchage, CONFOR'INO ne procède à
        aucune prospection commerciale non sollicitée, en particulier concernant les prestations
        d'adaptation liées au handicap ou au vieillissement, et recueille un consentement
        explicite et préalable avant toute prise de contact commerciale.</p>

        <h2>Réclamations et médiation</h2>
        <p>Pour toute réclamation, contactez-nous à contact@conforino.fr. À défaut de réponse
        satisfaisante, vous pouvez saisir gratuitement le médiateur CM2C (Centre de la Médiation
        de la Consommation), 49 rue de Ponthieu, 75008 Paris — www.cm2c.net.</p>

        <h2>Garanties</h2>
        <p>Nos prestations sont couvertes par une assurance responsabilité civile professionnelle
        et une garantie décennale souscrites auprès de GROUPAMA PARIS VAL DE LOIRE.</p>
        HTML;
    }

    protected function cgvHtml(): string
    {
        return <<<'HTML'
        <h2>Objet</h2>
        <p>CONFOR'INO intervient en plomberie, rénovation intérieure, création de salles de bain,
        aménagement PMR et travaux de second œuvre intérieur.</p>

        <h2>Devis et formation du contrat</h2>
        <p>Les devis sont valables trente (30) jours à compter de leur émission. Le contrat est
        formé après signature du devis par le client. Toute modification du périmètre des travaux
        fait l'objet d'un avenant écrit.</p>

        <h2>Délais d'exécution</h2>
        <p>Les travaux sont réalisés selon le calendrier fixé au devis, sous réserve d'un
        allongement justifié par un avenant, un cas de force majeure, un retard fournisseur, une
        contrainte technique imprévue ou des conditions climatiques défavorables.</p>

        <h2>Paiement</h2>
        <p>Un acompte de 40 % est demandé à la commande, le solde étant dû selon l'échéancier fixé
        au devis. Les règlements s'effectuent par virement, chèque ou espèces. Tout retard de
        paiement entraîne l'application de pénalités au taux d'intérêt légal majoré de dix (10)
        points, de plein droit et sans mise en demeure préalable.</p>

        <h2>Garanties</h2>
        <p>CONFOR'INO est assurée en responsabilité civile professionnelle et garantie décennale
        auprès de GROUPAMA PARIS VAL DE LOIRE. Les garanties légales de parfait achèvement et de
        bon fonctionnement s'appliquent conformément à la loi.</p>

        <h2>Réclamations et médiation</h2>
        <p>En cas de litige, le client consommateur peut saisir gratuitement le médiateur CM2C
        après une démarche préalable écrite restée sans réponse satisfaisante de CONFOR'INO.</p>

        <h2>Droit applicable</h2>
        <p>Les présentes conditions générales de vente et d'exécution des travaux sont soumises
        au droit français.</p>
        HTML;
    }
}
