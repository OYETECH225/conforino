@php
    $breadcrumbBadges = [
        ['icon' => 'check', 'text' => 'Devis gratuit & sans engagement'],
        ['icon' => 'shield', 'text' => 'Garantie décennale Groupama', 'solid' => true],
    ];
@endphp

<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb" :breadcrumb-badges="$breadcrumbBadges">

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6">
        <p class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-navy/60">
            <span class="h-px w-6 bg-turquoise"></span>
            Chantier témoin @if($realisation->city) • {{ $realisation->city->name }} @endif
        </p>
        <h1 class="cote mt-2 font-display text-3xl font-bold text-navy sm:text-4xl">{{ $realisation->title }}</h1>

        <div class="mt-10">
            <x-before-after-slider
                :before="$realisation->beforeUrl()"
                :after="$realisation->afterUrl()"
                :before-alt="$realisation->title.' — avant travaux'"
                :after-alt="$realisation->title.' — après travaux'"
            />
        </div>

        <div class="mt-10 grid gap-10 md:grid-cols-3">
            <div class="md:col-span-2">
                <h2 class="cote font-display text-xl font-bold text-navy">Le projet</h2>
                @if($realisation->description)
                    <p class="mt-6 text-[15px] leading-relaxed text-navy/80">{{ $realisation->description }}</p>
                @endif

                @if($realisation->service)
                    <p class="mt-6">
                        <a href="{{ route('services.show', $realisation->service->slug) }}" class="inline-flex items-center gap-1 font-semibold text-turquoise-dark">
                            Voir la prestation : {{ $realisation->service->title }} <span aria-hidden="true">→</span>
                        </a>
                    </p>
                @endif
            </div>

            <div class="divide-y divide-stone/20 border border-stone/20 bg-navy-tint/40 text-sm">
                @if($realisation->city)
                    <div class="flex items-center justify-between gap-3 px-4 py-3">
                        <span class="font-semibold uppercase tracking-wide text-navy/60">Ville</span>
                        <span class="text-navy">{{ $realisation->city->name }}</span>
                    </div>
                @endif
                @if($realisation->surface)
                    <div class="flex items-center justify-between gap-3 px-4 py-3">
                        <span class="font-semibold uppercase tracking-wide text-navy/60">Surface</span>
                        <span class="text-navy">{{ $realisation->surface }}</span>
                    </div>
                @endif
                @if($realisation->duration)
                    <div class="flex items-center justify-between gap-3 px-4 py-3">
                        <span class="font-semibold uppercase tracking-wide text-navy/60">Durée des travaux</span>
                        <span class="text-navy">{{ $realisation->duration }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-2 px-4 py-3 text-turquoise-dark">
                    <x-brand-icon name="shield" class="h-4 w-4 shrink-0" />
                    <span class="text-[13px] font-medium">Garantie décennale Groupama</span>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-navy-tint py-16" id="devis">
        <x-contact-card
            eyebrow="Un projet similaire ?"
            heading="Demandez votre devis gratuit"
            intro="Décrivez votre projet, nous revenons vers vous sous 48h ouvrées."
        />
    </section>
</x-layout>
