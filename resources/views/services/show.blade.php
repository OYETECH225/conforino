@php
    $heroTitle = $city ? "{$service->title} à {$city->name}" : $service->title;
    $heroSubtitle = $city
        ? ($pivot->local_intro ?: $service->short_description)
        : $service->short_description;
    $locationLine = $city
        ? ($city->postal_code ? "{$city->postal_code} • {$city->name} & Val-d'Oise" : "{$city->name} & Val-d'Oise")
        : "Argenteuil (95) & Val-d'Oise";
    $witnessRealisation = $realisations->first();

    $breadcrumbBadges = $service->breadcrumb_badges ?: [
        ['icon' => 'check', 'text' => 'Devis gratuit & sans engagement'],
        ['icon' => 'shield', 'text' => 'Garantie décennale Groupama', 'solid' => true],
    ];
@endphp

<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb" :breadcrumb-badges="$breadcrumbBadges">

    <section class="border-b border-stone/20 bg-white">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 md:py-20 lg:gap-16 lg:px-8">
            <div class="flex flex-col gap-6">
                <p class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-navy/60">
                    <span class="h-px w-6 bg-turquoise"></span>
                    <x-brand-icon :name="$service->icon" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                    {{ $service->title }}
                </p>

                <h1 class="cote font-display text-3xl font-bold leading-tight text-navy sm:text-4xl">{{ $heroTitle }}</h1>

                <p class="flex items-center gap-2 text-sm font-semibold text-navy/60">
                    <span class="h-1.5 w-px bg-turquoise"></span>
                    <span class="h-px w-16 bg-turquoise"></span>
                    <span class="h-1.5 w-px bg-turquoise"></span>
                    {{ $locationLine }}
                </p>

                @if($heroSubtitle)
                    <p class="max-w-md text-lg text-navy/80">{{ $heroSubtitle }}</p>
                @endif

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('page.show', 'contact') }}" class="btn-primary">Recevoir mon devis gratuit →</a>
                    <a href="{{ route('realisations.index') }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-navy-tint px-6 font-medium text-navy transition-colors hover:bg-navy-tint/70" style="min-height:44px">
                        Voir nos réalisations
                    </a>
                </div>
            </div>

            <div>
                <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint sm:aspect-[16/11]">
                    @if($service->imageUrl())
                        <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}@if($city) à {{ $city->name }}@endif" class="h-full w-full object-cover" loading="eager">
                    @else
                        <x-blueprint-pattern label="Photo à venir" />
                    @endif

                    @if($service->corner_badge_text)
                        <div class="absolute right-3 top-3 flex items-center gap-1.5 bg-navy-deep/90 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide text-white">
                            @if($service->corner_badge_icon)
                                <x-brand-icon :name="$service->corner_badge_icon" class="h-3.5 w-3.5 shrink-0 text-turquoise" />
                            @endif
                            {{ $service->corner_badge_text }}
                        </div>
                    @endif

                    @if($witnessRealisation)
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-deep/90 to-transparent p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-turquoise">
                                Chantier témoin @if($witnessRealisation->city) • {{ $witnessRealisation->city->name }} @endif
                            </p>
                            <p class="font-display text-lg font-bold text-white">{{ $witnessRealisation->title }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($service->long_description)
        <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
            <x-section-heading>Ce que nous faisons</x-section-heading>
            <div class="prose mt-6 max-w-none prose-headings:font-display prose-headings:text-navy prose-a:text-turquoise-dark">
                {!! $service->long_description !!}
            </div>
        </section>
    @endif

    {{-- Sections bespoke entièrement éditables depuis l'admin (corps de métier,
         protocole, normes PMR, comparatifs...) --}}
    <x-render-blocks :blocks="$service->activeBlocks" />

    @if($witnessRealisation)
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <x-section-heading eyebrow="Exemple de chantier">Un chantier récemment réalisé</x-section-heading>
            <div class="mt-10 grid gap-10 md:grid-cols-2 md:items-center">
                <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint">
                    <img src="{{ $witnessRealisation->afterUrl() }}" alt="{{ $witnessRealisation->title }}" class="h-full w-full object-cover" loading="lazy">
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-turquoise-dark">
                        @if($witnessRealisation->city){{ $witnessRealisation->city->name }}@endif
                    </p>
                    <h3 class="mt-2 font-display text-xl font-bold text-navy">{{ $witnessRealisation->title }}</h3>
                    @if($witnessRealisation->description)
                        <p class="mt-4 text-[15px] leading-relaxed text-navy/80">{{ $witnessRealisation->description }}</p>
                    @endif
                    <a href="{{ route('realisations.show', $witnessRealisation->slug) }}" class="mt-4 inline-flex items-center gap-1 font-semibold text-turquoise-dark">
                        Voir le chantier complet <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if($realisations->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <x-section-heading>Avant / après</x-section-heading>
            <div class="mt-10 grid gap-10 md:grid-cols-2">
                @foreach($realisations as $realisation)
                    <x-before-after-slider :before="$realisation->beforeUrl()" :after="$realisation->afterUrl()" :caption="$realisation->title" />
                @endforeach
            </div>
        </section>
    @endif

    @if($otherCities->isNotEmpty())
        <section class="bg-navy-tint py-16">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <x-section-heading>
                    Zones desservies {{ $city ? 'autour de '.$city->name : '' }}
                </x-section-heading>
                <ul class="mt-8 flex flex-wrap gap-3">
                    @foreach($otherCities as $otherCity)
                        <li>
                            <a href="{{ route('services.show', $service->slug.'-'.$otherCity->slug) }}" class="inline-flex items-center gap-2 rounded-sm border border-stone/30 bg-white px-4 py-2 text-[15px] text-navy hover:border-turquoise" style="min-height:44px">
                                <x-brand-icon name="pin" class="h-4 w-4 text-turquoise-dark" />
                                {{ $service->title }} à {{ $otherCity->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @if($reviews->isNotEmpty())
        <section class="bg-navy-tint py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <x-section-heading align="center">Nos clients s'expriment</x-section-heading>
                <x-testimonial-carousel :reviews="$reviews" />
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-5xl px-4 py-14 text-center sm:px-6">
        <p class="text-navy/80">Une question sur ce projet ?</p>
        <a href="{{ route('page.show', 'faq') }}" class="mt-2 inline-block font-medium text-turquoise-dark underline">Consulter la FAQ</a>
    </section>

    <section class="bg-navy-tint py-16" id="devis">
        <x-contact-card
            eyebrow="Devis rapide & gratuit"
            heading="Recevez votre devis gratuit"
            intro="Réponse sous 48h ouvrées, sans engagement."
        />
    </section>
</x-layout>
