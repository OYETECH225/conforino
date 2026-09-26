@props(['class' => 'h-10 w-10', 'animated' => false])

{{--
    Pictogramme maison + accessibilité, trait fin turquoise — repris du logo
    CONFOR'INO. Quand $animated est vrai (hero de l'accueil), le contour se
    trace au chargement via stroke-dasharray, seul moment animé du site.
--}}
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" stroke="#40BBC9" stroke-width="1.6"
     stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}"
     @if($animated) data-logo-draw @endif aria-hidden="true">
    <path d="M6 24 24 8l18 16" />
    <path d="M10 20v18a1 1 0 0 0 1 1h9V29h8v10h9a1 1 0 0 0 1-1V20" />
    <circle cx="24" cy="24" r="2.2" />
    <path d="M22.5 27 21 32h6l2.5 5" />
    <path d="M19.5 35a4 4 0 1 0 6.7 3" />
</svg>

@if($animated)
    @once
        <style>
            [data-logo-draw] path,
            [data-logo-draw] circle {
                stroke-dasharray: 220;
                stroke-dashoffset: 220;
                animation: draw-logo 1.6s ease-out forwards;
            }

            @keyframes draw-logo {
                to { stroke-dashoffset: 0; }
            }

            @media (prefers-reduced-motion: reduce) {
                [data-logo-draw] path,
                [data-logo-draw] circle {
                    animation: none;
                    stroke-dashoffset: 0;
                }
            }
        </style>
    @endonce
@endif
