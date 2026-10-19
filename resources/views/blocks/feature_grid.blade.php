@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $items = $block->get('items', []);
@endphp

@if(!empty($items))
    <section class="bg-navy-tint py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            @if($heading)
                <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
            @endif
            @if($intro)
                <p class="mt-4 max-w-2xl text-[15px] text-navy/75">{{ $intro }}</p>
            @endif

            <div class="mt-10 grid items-start gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($items as $index => $item)
                    <div class="reveal reveal-delay-{{ min($index + 1, 5) }} bg-white p-6">
                        <div class="h-1 w-10 bg-turquoise"></div>
                        <div class="mt-5 flex items-center gap-3">
                            <x-brand-icon :name="$item['icon'] ?? 'check'" class="h-6 w-6 shrink-0 text-turquoise-dark" />
                            <h3 class="font-display text-base font-bold text-navy">{{ $item['title'] ?? '' }}</h3>
                        </div>
                        @if(!empty($item['text']))
                            <p class="mt-3 text-[15px] leading-relaxed text-navy/75">{{ $item['text'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
