@php $heading = $block->get('heading'); $items = $block->get('items', []); @endphp

@if(!empty($items))
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        @if($heading)
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
        @endif

        <div class="mt-8 divide-y divide-stone/25 border-y border-stone/25">
            @foreach($items as $item)
                <details class="group py-4">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-[17px] font-medium text-navy" style="min-height:44px">
                        {{ $item['question'] ?? '' }}
                        <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-turquoise-dark transition-transform group-open:rotate-45" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                    </summary>
                    <div class="prose mt-3 max-w-none pr-8 text-[15px] text-navy/80 prose-a:text-turquoise-dark">
                        {!! $item['answer'] ?? '' !!}
                    </div>
                </details>
            @endforeach
        </div>
    </section>
@endif
