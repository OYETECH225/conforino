@props(['reviews'])

{{--
    Carrousel horizontal piloté par l'utilisateur (boutons + molette/tactile),
    jamais en défilement automatique : résout le problème de section trop
    haute quand il y a beaucoup d'avis, sans les écueils UX/accessibilité
    d'un slider auto-rotatif (voir la discussion sur le hero).
--}}
<div x-data="{ scrollBy(amount) { this.$refs.track.scrollBy({ left: amount, behavior: 'instant' }); } }" class="mt-10 min-w-0 max-w-full">
    <div
        x-ref="track"
        class="flex min-w-0 max-w-full items-start gap-6 overflow-x-auto pb-2 snap-x snap-proximity scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
        tabindex="0"
        role="region"
        aria-label="Avis clients (utilisez les flèches pour défiler)"
    >
        @foreach($reviews as $review)
            <figure class="w-[85%] shrink-0 snap-start border-l-4 border-turquoise bg-white p-6 sm:w-[380px]">
                <x-star-rating :rating="$review->rating" />
                <blockquote class="mt-3 font-serif text-lg italic leading-relaxed text-navy">
                    « {{ $review->text }} »
                </blockquote>
                <figcaption class="mt-4 text-sm text-navy/70">
                    {{ $review->author_name }}@if($review->cityName()), {{ $review->cityName() }}@endif
                    @if($review->source === 'google') · Avis Google @endif
                    <span class="sr-only">— note {{ $review->rating }}/5</span>
                </figcaption>
            </figure>
        @endforeach
    </div>

    @if($reviews->count() > 1)
        <div class="mt-5 flex justify-end gap-3">
            <button
                type="button"
                @click="scrollBy(-400)"
                class="flex items-center justify-center rounded-full border border-navy/20 text-navy hover:border-turquoise-dark hover:text-turquoise-dark"
                style="height:44px;width:44px"
                aria-label="Avis précédents"
            >
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 6l-6 6 6 6" />
                </svg>
            </button>
            <button
                type="button"
                @click="scrollBy(400)"
                class="flex items-center justify-center rounded-full border border-navy/20 text-navy hover:border-turquoise-dark hover:text-turquoise-dark"
                style="height:44px;width:44px"
                aria-label="Avis suivants"
            >
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </button>
        </div>
    @endif
</div>
