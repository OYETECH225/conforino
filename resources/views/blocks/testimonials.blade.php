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

            <div class="mt-10 grid gap-8 md:grid-cols-2">
                @foreach($reviews as $review)
                    <figure class="border-l-2 border-turquoise pl-6">
                        <div class="flex items-center gap-1 text-turquoise-dark" aria-hidden="true">
                            @for($i = 0; $i < $review->rating; $i++)
                                <x-brand-icon name="star" class="h-4 w-4" />
                            @endfor
                        </div>
                        <blockquote class="mt-3 font-serif text-lg italic leading-relaxed text-navy">
                            « {{ $review->text }} »
                        </blockquote>
                        <figcaption class="mt-3 text-sm text-navy/70">
                            {{ $review->author_name }}@if($review->cityName()), {{ $review->cityName() }}@endif
                            <span class="sr-only">— note {{ $review->rating }}/5</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
