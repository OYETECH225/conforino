@php
    $heading = $block->get('heading');
    $reviewIds = $block->get('review_ids', []);
    $reviews = \App\Models\Review::query()->published()->whereIn('id', $reviewIds)->get()->sortBy(fn ($r) => array_search($r->id, $reviewIds));
@endphp

@if($reviews->isNotEmpty())
    <section class="bg-turquoise-tint py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            @if($heading)
                <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
            @endif

            <x-testimonial-carousel :reviews="$reviews" />
        </div>
    </section>
@endif
