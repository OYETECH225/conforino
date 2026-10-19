@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $count = (int) $block->get('count', 4) ?: 4;
    $realisations = \App\Models\Realisation::query()->published()->ordered()->with('city')->limit($count)->get();
@endphp

@if($realisations->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        @if($heading)
            <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
        @endif

        <div class="mt-10 grid gap-10 sm:grid-cols-2">
            @foreach($realisations as $index => $realisation)
                <a href="{{ route('realisations.show', $realisation->slug) }}" class="reveal reveal-delay-{{ min($index + 1, 5) }} group block">
                    <div class="relative aspect-[16/10] overflow-hidden bg-navy-tint">
                        @if($realisation->afterUrl())
                            <img src="{{ $realisation->afterUrl() }}" alt="{{ $realisation->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        @else
                            <x-blueprint-pattern />
                        @endif
                        @if($realisation->city)
                            <span class="absolute left-3 top-3 bg-navy-deep/85 px-3 py-1 text-xs font-semibold text-white">
                                {{ $realisation->city->name }} @if($realisation->city->postal_code)({{ $realisation->city->postal_code }})@endif
                            </span>
                        @endif
                    </div>
                    <h3 class="mt-4 font-display text-lg font-bold text-navy">{{ $realisation->title }}</h3>
                    @if($realisation->description)
                        <p class="mt-2 text-[15px] text-navy/75">{{ $realisation->description }}</p>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            <a href="{{ route('realisations.index') }}" class="inline-flex items-center gap-1 font-semibold text-turquoise-dark">
                Voir toutes nos réalisations <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
@endif
