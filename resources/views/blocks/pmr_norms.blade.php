@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $items = $block->get('items', []);
@endphp

{{--
    Illustrations fixes (giration / passage de porte) en trait fin, dans le
    style de la marque — seules les valeurs et légendes sont éditables depuis
    l'admin, les schémas eux-mêmes sont un repère visuel, pas du texte libre.
--}}
@if(!empty($items))
    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        @if($heading)
            <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
        @endif
        @if($intro)
            <p class="mt-4 max-w-2xl text-[15px] text-navy/75">{{ $intro }}</p>
        @endif

        <div class="mt-10 grid gap-10 sm:grid-cols-2">
            @foreach($items as $item)
                <div class="bg-navy-tint p-6">
                    @if(($item['diagram'] ?? null) === 'passage')
                        <svg viewBox="0 0 220 220" class="mx-auto h-auto w-full max-w-[280px]" fill="none" stroke="#1E3664" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 60h55M150 60h55" stroke="#9AA3AE" stroke-width="2.5" />
                            <path d="M70 60v80" stroke="#1E3664" stroke-width="2.2" />
                            <path d="M70 140a80 80 0 0 0 80-80" stroke-dasharray="2 5" />
                            <path d="M70 100h80" stroke="#40BBC9" stroke-width="1.6" />
                            <path d="M70 94v12M150 94v12" stroke="#40BBC9" stroke-width="1.2" />
                        </svg>
                    @else
                        <svg viewBox="0 0 220 220" class="mx-auto h-auto w-full max-w-[280px]" fill="none" stroke="#1E3664" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 15h190v190H15z" stroke="#9AA3AE" stroke-width="1" />
                            <circle cx="110" cy="110" r="75" stroke="#40BBC9" stroke-width="1.6" />
                            <path d="M35 110h150" stroke="#40BBC9" stroke-width="1.2" stroke-dasharray="3 4" />
                            <path d="M35 104v12M185 104v12" stroke="#40BBC9" stroke-width="1.2" />
                            <path d="M15 170v-35" stroke="#1E3664" stroke-width="2.2" />
                            <path d="M15 170a35 35 0 0 0 35-35" stroke-dasharray="2 5" />
                        </svg>
                    @endif
                    <p class="mt-4 text-center font-serif text-2xl font-medium text-turquoise-dark">{{ $item['value'] ?? '' }}</p>
                    <p class="text-center text-sm text-navy/70">{{ $item['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endif
