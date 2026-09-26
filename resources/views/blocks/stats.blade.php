@php $heading = $block->get('heading'); $items = $block->get('items', []); @endphp

<section class="bg-navy-deep py-16 text-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        @if($heading)
            <h2 class="font-display text-2xl font-semibold sm:text-3xl">
                <span class="cote">{{ $heading }}</span>
            </h2>
        @endif

        <div class="mt-12 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($items as $item)
                <div>
                    <p class="font-serif text-4xl font-medium text-turquoise sm:text-5xl">{{ $item['value'] ?? '' }}</p>
                    <div class="mt-3 h-px w-10 bg-turquoise relative">
                        <span class="absolute -left-px -top-1 h-2 w-px bg-turquoise"></span>
                        <span class="absolute -right-px -top-1 h-2 w-px bg-turquoise"></span>
                    </div>
                    <p class="mt-3 text-[15px] text-white/75">{{ $item['label'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
