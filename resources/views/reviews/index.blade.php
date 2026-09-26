<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <h1 class="font-display text-3xl font-semibold text-navy sm:text-4xl">Avis clients</h1>
        @if($reviews->isNotEmpty())
            <p class="mt-4 text-lg text-navy/75">
                Note moyenne de {{ number_format($reviews->avg('rating'), 1) }}/5 sur {{ $reviews->count() }} avis.
            </p>
        @endif

        @if($reviews->isEmpty())
            <p class="mt-12 text-navy/60">Les premiers avis seront bientôt publiés ici.</p>
        @else
            {{-- Colonnes CSS (pas une grille) : chaque avis garde sa propre hauteur
                 au lieu d'être étiré par le plus long avis de sa ligne. --}}
            <div class="mt-12 columns-1 gap-8 md:columns-2">
                @foreach($reviews as $review)
                    <figure class="mb-8 break-inside-avoid border-l-2 border-turquoise pl-6">
                        <x-star-rating :rating="$review->rating" />
                        <blockquote class="mt-3 font-serif text-lg italic leading-relaxed text-navy">« {{ $review->text }} »</blockquote>
                        <figcaption class="mt-3 text-sm text-navy/70">
                            {{ $review->author_name }}@if($review->cityName()), {{ $review->cityName() }}@endif
                            @if($review->source === 'google') · Avis Google @endif
                            <span class="sr-only">— note {{ $review->rating }}/5</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
