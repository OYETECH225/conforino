@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $steps = $block->get('steps', []);
    $trustItems = $block->get('trust_items', []);
@endphp

@if(!empty($steps))
    <section class="bg-navy-tint py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            @if($heading)
                <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
            @endif

            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                @foreach($steps as $index => $step)
                    <div class="reveal reveal-delay-{{ min($index + 1, 5) }} relative bg-white p-6">
                        <div class="h-1 w-10 bg-turquoise"></div>
                        <p class="mt-5 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-navy/60">
                            @if(!empty($step['icon']))
                                <x-brand-icon :name="$step['icon']" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                            @endif
                            Phase {{ sprintf('%02d', $index + 1) }}
                        </p>
                        <h3 class="mt-2 font-display text-lg font-bold text-navy">{{ $step['title'] ?? '' }}</h3>
                        @if(!empty($step['description']))
                            <p class="mt-3 text-[15px] leading-relaxed text-navy/75">{{ $step['description'] }}</p>
                        @endif
                        @if(!empty($step['proof']))
                            <p class="mt-4 flex items-center gap-1.5 text-sm font-medium text-turquoise-dark">
                                {{ $step['proof'] }}
                                <x-brand-icon name="check" class="h-4 w-4 shrink-0" />
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            @if(!empty($trustItems))
                <div class="mt-6 grid gap-6 bg-white p-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($trustItems as $item)
                        <div class="flex items-start gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center bg-navy-tint">
                                <x-brand-icon :name="$item['icon'] ?? 'check'" class="h-5 w-5 text-turquoise-dark" />
                            </span>
                            <span class="text-[15px] text-navy/80">{{ $item['text'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
