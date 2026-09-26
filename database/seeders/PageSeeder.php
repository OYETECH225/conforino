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
                'heading' => "CONFOR'INO réalise vos projets de salle de bain, de douche sécurisée et d'adaptation PMR",
                'subheading' => "Entreprise de rénovation basée à Argenteuil, nous accompagnons particuliers et professionnels dans leurs projets de salle de bain, d'adaptation PMR et de rénovation intérieure — un accompagnement attentif, du premier échange aux dernières finitions.",
                'image' => $this->seedImage('hero-homepage.webp'),
                'cta_label' => 'Recevoir mon devis gratuit',
                'cta_url' => '/contact',
            ]),
            $this->block('process', [
                'heading' => 'Notre méthode',
                'steps' => [
                    [
                        'title' => 'Étude personnalisée',
                        'points' => ['Analyse de votre espace', 'Conseils adaptés à vos besoins', 'Solutions esthétiques et fonctionnelles'],
                    ],
                    [
                        'title' => 'Projet clé en main',
                        'points' => ['Conception et choix des équipements', 'Coordination complète des travaux', 'Un interlocuteur unique'],
                    ],
                    [
                        'title' => 'Confort & autonomie',
                        'points' => ['Aménagements accessibles et sécurisés', 'Circulation facilitée au quotidien', 'Un résultat durable et élégant'],
                    ],
                ],
            ]),
            $this->block('stats', [
                'heading' => 'Pourquoi nous choisir',
                'items' => [
                    ['value' => '13 ans', 'label' => "d'expérience en rénovation et agencement"],
                    ['value' => '200+', 'label' => 'projets et clients accompagnés'],
                    ['value' => 'Décennale', 'label' => 'garantie sur tous nos chantiers'],
                    ['value' => 'RC Pro', 'label' => 'assurance responsabilité civile professionnelle'],
                ],
            ]),
            $this->block('services_grid', [
                'heading' => 'Nos expertises',
                'items' => [
                    ['icon' => 'kitchen', 'title' => 'Agencement cuisine', 'summary' => 'Cuisines sur mesure, conception et pose complète.', 'url' => '/services/agencement-cuisine'],
                    ['icon' => 'bathroom', 'title' => 'Agencement salle de bain', 'summary' => "Création ou rénovation de salle de bain clé en main.", 'url' => '/services/agencement-salle-de-bain'],
                    ['icon' => 'pmr', 'title' => 'Aménagement PMR', 'summary' => "Douches sécurisées, barres d'appui, accessibilité.", 'url' => '/services/amenagement-pmr'],
                    ['icon' => 'renovation', 'title' => 'Rénovation intérieure', 'summary' => 'Plomberie, électricité, peinture, cloisons.', 'url' => '/services/renovation-interieure'],
                ],
            ]),
            $this->block('gallery_preview', ['heading' => 'Nos réalisations', 'count' => 4]),
            $this->block('testimonials', [
                'heading' => "Nos clients s'expriment",
                'review_ids' => Review::query()->published()->pluck('id')->all(),
            ]),
            $this->block('service_areas', [
                'heading' => "Zones d'intervention",
                'intro' => "Nous intervenons principalement dans le Val-d'Oise et les communes voisines suivantes :",
                'city_ids' => City::query()->active()->pluck('id')->all(),
            ]),
            $this->block('faq', [
                'heading' => 'Questions fréquentes',
                'items' => [
                    ['question' => 'Réalisez-vous des salles de bain PMR et douches sécurisées ?', 'answer' => "<p>Oui. CONFOR'INO réalise l'adaptation de salles de bain PMR, l'installation de douches sécurisées, la pose de barres d'appui et le remplacement de baignoires par des douches accessibles.</p>"],
                    ['question' => 'Le devis de rénovation est-il gratuit ?', 'answer' => '<p>Oui. Chaque projet fait l\'objet d\'une première étude et d\'un devis gratuit, sans engagement. Une visite technique peut être nécessaire pour confirmer la faisabilité et le prix.</p>'],
                    ['question' => 'Dans quelles villes intervenez-vous ?', 'answer' => "<p>Nous intervenons à {$cityList}, ainsi que dans les autres communes du Val-d'Oise sur demande.</p>"],
                    ['question' => 'Les travaux sont-ils couverts par une garantie ?', 'answer' => '<p>Oui. Nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale (Groupama).</p>'],
                ],
            ]),
            $this->block('contact_form', [
                'heading' => 'Recevez votre devis personnalisé',
                'intro' => 'Décrivez votre projet, nous revenons vers vous sous 48h ouvrées.',
            ]),
        ]);

        $this->page('services', 'Services', 'index,follow', 'WebPage', [
            $this->block('hero', [
                'heading' => 'Nos prestations de rénovation et d\'aménagement',
                'subheading' => "Agencement cuisine, salle de bain, aménagement PMR et rénovation intérieure : découvrez l'ensemble de nos savoir-faire.",
            ]),
            $this->block('services_grid', [
                'items' => [
                    ['icon' => 'kitchen', 'title' => 'Agencement cuisine', 'summary' => 'Cuisines sur mesure, conception et pose complète.', 'url' => '/services/agencement-cuisine'],
                    ['icon' => 'bathroom', 'title' => 'Agencement salle de bain', 'summary' => "Création ou rénovation de salle de bain clé en main.", 'url' => '/services/agencement-salle-de-bain'],
                    ['icon' => 'pmr', 'title' => 'Aménagement PMR', 'summary' => "Douches sécurisées, barres d'appui, accessibilité.", 'url' => '/services/amenagement-pmr'],
                    ['icon' => 'renovation', 'title' => 'Rénovation intérieure', 'summary' => 'Plomberie, électricité, peinture, cloisons.', 'url' => '/services/renovation-interieure'],
                ],
            ]),
        ]);

        $this->page('faq', 'FAQ', 'index,follow', 'FAQPage', [
            $this->block('hero', ['heading' => 'Questions fréquentes sur nos travaux']),
            $this->block('faq', [
                'items' => [
                    ['question' => 'Quels types de travaux propose CONFOR\'INO ?', 'answer' => "<p>CONFOR'INO est spécialisée dans la rénovation intérieure (plomberie, électricité, peinture, cloisons), les travaux d'accessibilité PMR et l'agencement de cuisines et salles de bain.</p>"],
                    ['question' => 'Intervenez-vous uniquement dans le Val-d\'Oise ?', 'answer' => "<p>Nous sommes basés à Argenteuil (95) et intervenons principalement à {$cityList}. Nous nous déplaçons également ailleurs en Île-de-France selon les projets.</p>"],
                    ['question' => 'Proposez-vous des devis gratuits ?', 'answer' => '<p>Oui, nous proposons des devis gratuits, personnalisés et sans engagement. Il vous suffit de remplir notre formulaire de contact ou de nous appeler.</p>'],
                    ['question' => 'Proposez-vous des prestations pour les personnes à mobilité réduite (PMR) ?', 'answer' => "<p>Oui, nous réalisons des aménagements d'accessibilité PMR : douches sécurisées, barres d'appui, rampes d'accès, mains courantes et dalles podotactiles.</p>"],
                    ['question' => 'Les travaux sont-ils couverts par une garantie ?', 'answer' => '<p>Oui. Nos prestations sont couvertes par une assurance responsabilité civile professionnelle et une garantie décennale souscrites auprès de Groupama.</p>'],
                    ['question' => 'Comment se déroule une demande de devis ?', 'answer' => '<p>Vous remplissez le formulaire de contact ou nous appelez directement. Nous vous recontactons pour qualifier votre projet, puis organisons si besoin une visite technique avant l\'envoi du devis.</p>'],
                ],
            ]),
        ]);

        $this->page('contact', 'Contact / Devis gratuit', 'index,follow', 'WebPage', [
            $this->block('hero', [
                'heading' => 'Contactez-nous pour votre projet',
                'subheading' => "Décrivez votre projet, nous revenons vers vous sous 48h ouvrées avec un premier retour.",
            ]),
            $this->block('contact_form', [
                'heading' => 'Demande de devis ou de renseignements',
                'intro' => 'Réponse sous 48h ouvrées, sans engagement.',
            ]),
        ]);

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

    protected function page(string $slug, string $title, string $robots, string $schemaType, array $blocks, bool $showBreadcrumb = true): void
    {
        $page = Page::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'status' => 'published',
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
