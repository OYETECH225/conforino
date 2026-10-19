@php
    $avgRating = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : null;
    $featured = $realisations->firstWhere('is_featured', true) ?? $realisations->first();

    $heroEyebrow = $heroBlock?->get('eyebrow') ?? 'Portfolio technique & études de cas';
    $heroHeading = $heroBlock?->get('heading') ?? "Nos réalisations : l'exigence au service de l'autonomie et du confort";
    $heroSubheading = $heroBlock?->get('subheading') ?? "Découvrez nos chantiers de rénovation complète, d'adaptation PMR sécurisée et d'agencement sur mesure réalisés à Argenteuil et dans tout le Val-d'Oise.";
    $heroCtaLabel = $heroBlock?->get('cta_label') ?? 'Demander mon étude gratuite';
    $heroCtaUrl = $heroBlock?->get('cta_url') ?? '#devis';
    $heroCta2Label = $heroBlock?->get('cta2_label') ?? 'Voir les chantiers';
    $heroCta2Url = $heroBlock?->get('cta2_url') ?? '#galerie';

    $extraStats = $statsBlock?->get('items') ?: [
        ['value' => '13 ans', 'label' => "d'expérience métier"],
        ['value' => 'Décennale', 'label' => 'garantie Groupama'],
        ['value' => '0€', 'label' => 'devis gratuit, sans surprise'],
    ];

    $charteEyebrow = $charteBlock?->get('eyebrow') ?? 'Méthodologie & rigueur';
    $charteHeading = $charteBlock?->get('heading') ?? 'La charte de qualité appliquée à chacun de nos chantiers';
    $charteItems = $charteBlock?->get('items') ?: [
        ['icon' => 'shield', 'title' => 'Protection du chantier', 'text' => "Sols, escaliers et parties communes protégés avant toute intervention, pour un chantier propre du premier au dernier jour."],
        ['icon' => 'check', 'title' => 'Propreté & tri des déchets', 'text' => "Évacuation régulière des gravats et tri sélectif, sans stockage prolongé sur la voie publique."],
        ['icon' => 'handshake', 'title' => 'Interlocuteur dédié', 'text' => 'Un seul interlocuteur suit votre chantier du premier échange à la réception, avec des points réguliers.'],
        ['icon' => 'shield', 'title' => 'Réception & décennale', 'text' => 'Contrôle final avant réception, chantier propre et garantie décennale Groupama sur les travaux réalisés.'],
    ];
@endphp

<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="border-b border-stone/20 bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <x-section-heading :eyebrow="$heroEyebrow">{{ $heroHeading }}</x-section-heading>
                    <p class="mt-4 max-w-md text-lg text-navy/75">{{ $heroSubheading }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ $heroCtaUrl }}" class="btn-primary">{{ $heroCtaLabel }} →</a>
                        <a href="{{ $heroCta2Url }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-navy-tint px-6 font-medium text-navy transition-colors hover:bg-navy-tint/70" style="min-height:44px">
                            {{ $heroCta2Label }}
                        </a>
                    </div>
                </div>

                @if($featured)
                    <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint sm:aspect-[16/11]">
                        <img src="{{ $featured->afterUrl() }}" alt="{{ $featured->title }}" class="h-full w-full object-cover" loading="eager">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-deep/90 to-transparent p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-turquoise">
                                Chantier récent @if($featured->city) • {{ $featured->city->name }} @endif
                            </p>
                            <p class="font-display text-lg font-bold text-white">{{ $featured->title }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-12 grid gap-4 border-t border-stone/20 pt-10 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Seul chiffre non éditable : calculé en direct pour rester toujours exact. --}}
                <div class="border border-stone/20 p-5">
                    <div class="flex items-center gap-2">
                        <x-brand-icon name="ruler" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                        <p class="text-xs font-semibold uppercase tracking-wide text-navy/50">Portfolio</p>
                    </div>
                    <p class="mt-2 font-serif text-3xl font-medium text-turquoise-dark">{{ $realisations->count() }}</p>
                    <p class="mt-1 text-sm text-navy/60">chantiers documentés ici</p>
                </div>
                @foreach($extraStats as $stat)
                    <div class="border border-stone/20 p-5">
                        <p class="mt-2 font-serif text-3xl font-medium text-turquoise-dark">{{ $stat['value'] ?? '' }}</p>
                        <p class="mt-1 text-sm text-navy/60">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="galerie" class="mx-auto max-w-7xl px-4 py-16 sm:px-6" x-data="{ active: 'all' }">
        <x-section-heading eyebrow="Galerie précision">Dernières transformations menées dans le Val-d'Oise</x-section-heading>

        @if($realisations->isNotEmpty())
            <div class="mt-8 flex flex-wrap gap-2">
                <button type="button" @click="active = 'all'" :class="active === 'all' ? 'bg-navy-deep text-white' : 'bg-navy-tint text-navy'" class="px-4 py-2 text-sm font-semibold" style="min-height:44px">
                    Tous les projets ({{ $realisations->count() }})
                </button>
                @foreach($services as $service)
                    @if($service->realisations_count > 0)
                        <button type="button" @click="active = {{ $service->id }}" :class="active === {{ $service->id }} ? 'bg-navy-deep text-white' : 'bg-navy-tint text-navy'" class="px-4 py-2 text-sm font-semibold" style="min-height:44px">
                            {{ $service->title }} ({{ $service->realisations_count }})
                        </button>
                    @endif
                @endforeach
            </div>

            <div class="mt-10 grid items-start gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($realisations as $realisation)
                    <a href="{{ route('realisations.show', $realisation->slug) }}" class="group block" x-show="active === 'all' || active === {{ $realisation->service_id ?? 'null' }}">
                        <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint">
                            @if($realisation->afterUrl())
                                <img src="{{ $realisation->afterUrl() }}" alt="{{ $realisation->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                            @else
                                <x-blueprint-pattern />
                            @endif
                            @if($realisation->service)
                                <span class="absolute bottom-3 left-3 bg-navy-deep/85 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">{{ $realisation->service->title }}</span>
                            @endif
                        </div>
                        <p class="mt-3 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-navy/50">
                            @if($realisation->city)
                                <x-brand-icon name="pin" class="h-3.5 w-3.5 shrink-0" /> {{ $realisation->city->name }}
                            @endif
                            @if($realisation->duration) · {{ $realisation->duration }} @endif
                        </p>
                        <h3 class="mt-1 font-display text-lg font-bold text-navy">{{ $realisation->title }}</h3>
                        @if($realisation->description)
                            <p class="mt-2 text-[15px] text-navy/75">{{ $realisation->description }}</p>
                        @endif
                        <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                            Voir le chantier <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-12 grid gap-4 grid-cols-2 md:grid-cols-4">
                @foreach([1, 2, 3, 4] as $placeholder)
                    <div class="aspect-square overflow-hidden">
                        <x-blueprint-pattern />
                    </div>
                @endforeach
            </div>
            <p class="mt-6 text-sm text-navy/60">
                Nos premiers chantiers seront bientôt publiés ici.
            </p>
        @endif
    </section>

    <section class="bg-navy-deep py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <p class="text-center text-xs font-semibold uppercase tracking-wide text-turquoise">{{ $charteEyebrow }}</p>
            <h2 class="mt-2 text-center font-display text-2xl font-bold sm:text-3xl">{{ $charteHeading }}</h2>
            <div class="mx-auto mt-4 h-0.5 w-16 bg-turquoise"></div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($charteItems as $index => $step)
                    <div class="border border-white/15 bg-white/5 p-6">
                        <p class="text-xs font-semibold uppercase tracking-wide text-turquoise">{{ $index + 1 }}.</p>
                        <div class="mt-2 flex items-center gap-3">
                            <x-brand-icon :name="$step['icon'] ?? 'check'" class="h-5 w-5 shrink-0 text-turquoise" />
                            <h3 class="font-display text-base font-bold text-white">{{ $step['title'] ?? '' }}</h3>
                        </div>
                        <p class="mt-3 text-[14px] leading-relaxed text-white/70">{{ $step['text'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($reviews->isNotEmpty())
        <section class="bg-navy-tint py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <x-section-heading eyebrow="Confiance & sérénité" align="center">Les retours d'expérience de nos clients val-d'oisiens</x-section-heading>
                @if($avgRating)
                    <p class="mt-4 flex items-center justify-center gap-2 text-navy/80">
                        <x-star-rating :rating="round($avgRating)" />
                        <span class="font-semibold text-navy">{{ $avgRating }}/5</span>
                        sur {{ $reviews->count() }} avis Google
                    </p>
                @endif
                <x-testimonial-carousel :reviews="$reviews" />
            </div>
        </section>
    @endif

    <section class="bg-navy-tint py-16" id="devis">
        <x-contact-card
            eyebrow="Étude technique sans frais"
            heading="Votre projet mérite une étude sur mesure"
            intro="Bénéficiez d'une visite technique gratuite et sans engagement à Argenteuil et dans tout le Val-d'Oise."
        />
    </section>
</x-layout>
