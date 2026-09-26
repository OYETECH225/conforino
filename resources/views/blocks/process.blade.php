@php $heading = $block->get('heading'); $steps = $block->get('steps', []); @endphp

{{-- Seul endroit du site avec une numérotation 01/02/03 : le parcours client
     est une vraie séquence, contrairement aux cartes de services ou aux
     chiffres clés qui n'en ont pas besoin. --}}
@if(!empty($steps))
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if($heading)
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
        @endif

        <div class="mt-12 grid gap-10 sm:grid-cols-3">
            @foreach($steps as $index => $step)
                <div class="relative">
                    <span class="font-serif text-3xl font-medium text-turquoise">{{ sprintf('%02d', $index + 1) }}</span>
                    <h3 class="mt-3 font-display text-lg font-semibold text-navy">{{ $step['title'] ?? '' }}</h3>
                    @if(!empty($step['points']))
                        <ul class="mt-3 space-y-2 text-[15px] text-navy/75">
                            @foreach($step['points'] as $point)
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-turquoise"></span>
                                    {{ is_array($point) ? ($point['point'] ?? '') : $point }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if(!$loop->last)
                        <div class="absolute right-[-1.25rem] top-2 hidden h-px w-10 bg-stone/40 sm:block"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endif
