<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        <h1 class="font-display text-3xl font-semibold text-navy sm:text-4xl">Nos réalisations</h1>
        <p class="mt-4 max-w-2xl text-lg text-navy/75">
            Un aperçu de nos chantiers de rénovation, agencement cuisine, salle de bain et adaptation PMR
            dans le Val-d'Oise.
        </p>

        @if($realisations->isNotEmpty())
            {{-- Grille "calepinage" : modules de tailles différentes plutôt qu'une grille uniforme --}}
            <div class="mt-12 grid auto-rows-[220px] grid-cols-2 gap-4 sm:auto-rows-[260px] md:grid-cols-4">
                @foreach($realisations as $index => $realisation)
                    @php
                        $pattern = $index % 6;
                        $span = match(true) {
                            $pattern === 0 => 'col-span-2 row-span-2',
                            $pattern === 3 => 'md:col-span-2',
                            default => '',
                        };
                    @endphp
                    <a href="{{ route('realisations.show', $realisation->slug) }}" class="group relative block overflow-hidden rounded-sm {{ $span }}">
                        @if($realisation->afterUrl())
                            <img src="{{ $realisation->afterUrl() }}" alt="{{ $realisation->title }}" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
                        @else
                            <x-blueprint-pattern />
                        @endif
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-deep/85 to-transparent p-4">
                            <p class="font-display text-sm font-medium text-white">{{ $realisation->title }}</p>
                            @if($realisation->city)
                                <p class="text-xs text-white/70">{{ $realisation->city->name }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-12 grid gap-4 grid-cols-2 md:grid-cols-4">
                @foreach([1, 2, 3, 4] as $placeholder)
                    <div class="aspect-square overflow-hidden rounded-sm">
                        <x-blueprint-pattern />
                    </div>
                @endforeach
            </div>
            <p class="mt-6 text-sm text-navy/60">
                Nos premiers chantiers seront bientôt publiés ici.
            </p>
        @endif
    </section>
</x-layout>
