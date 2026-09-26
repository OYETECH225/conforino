@php
    $heading = $block->get('heading');
    $count = (int) $block->get('count', 4) ?: 4;
    $realisations = \App\Models\Realisation::query()->published()->ordered()->limit($count)->get();
@endphp

@if($realisations->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        @if($heading)
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
        @endif

        <div class="mt-10 grid gap-4 grid-cols-2 md:grid-cols-4">
            @foreach($realisations as $index => $realisation)
                <a href="{{ route('realisations.show', $realisation->slug) }}"
                   class="group relative block aspect-square overflow-hidden rounded-sm {{ $index === 0 ? 'col-span-2 row-span-2' : '' }}">
                    @if($realisation->afterUrl())
                        <img src="{{ $realisation->afterUrl() }}" alt="{{ $realisation->title }}" class="h-full w-full object-cover transition group-hover:scale-105" loading="lazy">
                    @else
                        <x-blueprint-pattern />
                    @endif
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-deep/85 to-transparent p-3">
                        <p class="font-display text-sm font-medium text-white">{{ $realisation->title }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="{{ route('realisations.index') }}" class="font-medium text-turquoise-dark underline underline-offset-4">
                Voir toutes nos réalisations
            </a>
        </div>
    </section>
@endif
