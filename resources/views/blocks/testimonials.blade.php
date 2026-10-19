@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $reviewIds = $block->get('review_ids', []);
    $reviews = \App\Models\Review::query()->published()->whereIn('id', $reviewIds)->get()->sortBy(fn ($r) => array_search($r->id, $reviewIds));
@endphp

@if($reviews->isNotEmpty())
    <section class="overflow-x-hidden bg-navy-tint py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            @if($heading)
                <x-section-heading :eyebrow="$eyebrow" align="center">{{ $heading }}</x-section-heading>
            @endif

            <div class="reveal reveal-delay-2">
                <x-testimonial-carousel :reviews="$reviews" />
            </div>
        </div>
    </section>
@endif
