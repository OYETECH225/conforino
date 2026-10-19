@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $proofItems = $block->get('proof_items', []);
    $items = $block->get('items', []);
    $hasIntro = (bool) $intro;

    // Compteur animé uniquement pour la partie numérique en tête de valeur
    // (ex: "200+" -> anime 0→200 puis affiche "+" ; "Décennale" reste statique).
    $items = array_map(function ($item) {
        if (preg_match('/^(\d+)(.*)$/', trim($item['value'] ?? ''), $m)) {
            $item['countTo'] = (int) $m[1];
            $item['countSuffix'] = $m[2];
        }

        return $item;
    }, $items);
@endphp

<section class="bg-navy-deep py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        @if(!$hasIntro)
            <div class="text-center">
                @if($eyebrow)
                    <p class="flex items-center justify-center gap-2 text-sm font-semibold uppercase tracking-wide text-turquoise">
                        <x-brand-icon name="handshake" class="h-4 w-4 shrink-0" />
                        {{ $eyebrow }}
                    </p>
                @endif
                @if($heading)
                    <h2 class="cote-center mt-2 font-display text-2xl font-bold sm:text-3xl">{{ $heading }}<span class="tick-right"></span></h2>
                @endif
                @if(!empty($proofItems))
                    <ul class="mt-6 flex flex-wrap justify-center gap-x-6 gap-y-2 text-[15px] text-white/85">
                        @foreach($proofItems as $proof)
                            <li class="flex items-center gap-2">
                                <x-brand-icon name="check" class="h-4 w-4 shrink-0 text-turquoise" />
                                {{ is_array($proof) ? ($proof['text'] ?? '') : $proof }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($items as $index => $item)
                    <div class="reveal reveal-delay-{{ min($index + 1, 5) }} text-center">
                        <div class="mx-auto h-px w-16 bg-white/25 relative">
                            <span class="absolute -left-px -top-1 h-2 w-px bg-white/40"></span>
                            <span class="absolute -right-px -top-1 h-2 w-px bg-white/40"></span>
                        </div>
                        <p class="mt-4 font-serif text-4xl font-medium text-turquoise sm:text-5xl">
                            @if(isset($item['countTo']))
                                <span data-count-to="{{ $item['countTo'] }}" data-count-suffix="{{ $item['countSuffix'] }}">0{{ $item['countSuffix'] }}</span>
                            @else
                                {{ $item['value'] ?? '' }}
                            @endif
                        </p>
                        <p class="mt-3 text-[15px] text-white/75">{{ $item['label'] ?? '' }}</p>
                        @if(!empty($item['description']))
                            <p class="mt-1 text-sm text-white/55">{{ $item['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="grid gap-12 lg:grid-cols-2 lg:items-start">
                <div>
                    @if($eyebrow)
                        <p class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-turquoise">
                            <x-brand-icon name="handshake" class="h-4 w-4 shrink-0" />
                            {{ $eyebrow }}
                        </p>
                    @endif
                    @if($heading)
                        <h2 class="cote mt-2 font-display text-2xl font-bold sm:text-3xl">{{ $heading }}</h2>
                    @endif
                    <div class="prose prose-invert mt-8 max-w-none text-white/80 prose-p:text-white/80">
                        {!! nl2br(e($intro)) !!}
                    </div>
                    @if(!empty($proofItems))
                        <ul class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-[15px] text-white/85">
                            @foreach($proofItems as $proof)
                                <li class="flex items-center gap-2">
                                    <x-brand-icon name="check" class="h-4 w-4 shrink-0 text-turquoise" />
                                    {{ is_array($proof) ? ($proof['text'] ?? '') : $proof }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                    @foreach($items as $index => $item)
                        <div class="reveal reveal-delay-{{ min($index + 1, 5) }} border border-white/15 bg-white/5 p-6">
                            <div class="h-px w-full bg-white/20 relative">
                                <span class="absolute -left-px -top-1 h-2 w-px bg-white/40"></span>
                                <span class="absolute -right-px -top-1 h-2 w-px bg-white/40"></span>
                            </div>
                            <p class="mt-4 font-serif text-4xl font-medium text-turquoise">
                                @if(isset($item['countTo']))
                                    <span data-count-to="{{ $item['countTo'] }}" data-count-suffix="{{ $item['countSuffix'] }}">0{{ $item['countSuffix'] }}</span>
                                @else
                                    {{ $item['value'] ?? '' }}
                                @endif
                            </p>
                            <p class="mt-2 font-display text-[15px] font-semibold text-white">{{ $item['label'] ?? '' }}</p>
                            @if(!empty($item['description']))
                                <p class="mt-1 text-sm text-white/65">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
