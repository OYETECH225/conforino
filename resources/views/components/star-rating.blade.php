@props(['rating' => 5, 'max' => 5, 'class' => 'h-4 w-4'])

{{-- Étoiles pleines/creuses distinctes (pas seulement une couleur) pour que
     la note reste lisible sans dépendre de la couleur seule. --}}
<div class="flex items-center gap-0.5 text-turquoise-dark" aria-hidden="true">
    @for($i = 1; $i <= $max; $i++)
        @if($i <= $rating)
            <svg viewBox="0 0 24 24" class="{{ $class }}" fill="currentColor" aria-hidden="true">
                <path d="m12 3 2.6 5.6 6 .7-4.5 4.1 1.2 6-5.3-3-5.3 3 1.2-6-4.5-4.1 6-.7L12 3Z" />
            </svg>
        @else
            <svg viewBox="0 0 24 24" class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m12 3 2.6 5.6 6 .7-4.5 4.1 1.2 6-5.3-3-5.3 3 1.2-6-4.5-4.1 6-.7L12 3Z" />
            </svg>
        @endif
    @endfor
</div>
