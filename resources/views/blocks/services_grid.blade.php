@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $items = $block->get('items', []);
    $resolveUrl = fn ($path) => Illuminate\Support\Str::startsWith($path, ['http', '/storage']) ? $path : asset('storage/'.$path);
@endphp

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
    @if($heading)
        <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
    @endif
    @if($intro)
        <p class="mt-4 max-w-2xl text-[15px] text-navy/75">{{ $intro }}</p>
    @endif

    <div class="mt-10 grid items-start gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($items as $index => $item)
            @if(!empty($item['is_info_card']))
                <a href="{{ $item['url'] ?? '#' }}" class="reveal reveal-delay-{{ min($index + 1, 5) }} group block">
                    <div class="relative flex aspect-[4/3] flex-col items-center justify-center bg-navy-tint p-6 text-center">
                        <x-brand-icon :name="$item['icon'] ?? 'shield'" class="h-10 w-10 text-turquoise-dark" />
                        @if(!empty($item['info_label']))
                            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-navy/60">{{ $item['info_label'] }}</p>
                        @endif
                        @if(!empty($item['info_value']))
                            <p class="mt-2 font-display text-xl font-bold text-navy">{{ $item['info_value'] }}</p>
                        @endif
                        @if(!empty($item['title']))
                            <span class="absolute bottom-3 left-3 bg-navy-deep/85 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">{{ $item['title'] }}</span>
                        @endif
                    </div>
                    <h3 class="mt-4 font-display text-lg font-bold text-navy">{{ $item['title'] ?? '' }}</h3>
                    @if(!empty($item['summary']))
                        <p class="mt-2 text-[15px] text-navy/75">{{ $item['summary'] }}</p>
                    @endif
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                        En savoir plus <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
                    </span>
                </a>
            @else
                <a href="{{ $item['url'] ?? '#' }}" class="reveal reveal-delay-{{ min($index + 1, 5) }} group block">
                    <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint">
                        @if(!empty($item['image']))
                            <img src="{{ $resolveUrl($item['image']) }}" alt="{{ $item['title'] ?? '' }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        @else
                            <x-blueprint-pattern />
                        @endif
                        @if(!empty($item['tag']))
                            <span class="absolute bottom-3 left-3 bg-navy-deep/85 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">{{ $item['tag'] }}</span>
                        @endif
                    </div>
                    <h3 class="mt-4 font-display text-lg font-bold text-navy">{{ $item['title'] ?? '' }}</h3>
                    @if(!empty($item['summary']))
                        <p class="mt-2 text-[15px] text-navy/75">{{ $item['summary'] }}</p>
                    @endif
                    <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                        En savoir plus <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
                    </span>
                </a>
            @endif
        @endforeach
    </div>
</section>
