@php $heading = $block->get('heading'); $items = $block->get('items', []); @endphp

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
    @if($heading)
        <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
    @endif

    <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($items as $item)
            <a href="{{ $item['url'] ?? '#' }}" class="group block border border-stone/20 p-6 transition hover:border-turquoise">
                <x-brand-icon :name="$item['icon'] ?? 'renovation'" class="h-9 w-9 text-turquoise-dark" />
                <h3 class="mt-4 font-display text-lg font-semibold text-navy">{{ $item['title'] ?? '' }}</h3>
                @if(!empty($item['summary']))
                    <p class="mt-2 text-[15px] text-navy/75">{{ $item['summary'] }}</p>
                @endif
                <span class="mt-4 inline-block text-sm font-medium text-turquoise-dark underline-offset-4 group-hover:underline">En savoir plus</span>
            </a>
        @endforeach
    </div>
</section>
