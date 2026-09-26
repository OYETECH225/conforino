@props(['label' => null])

{{--
    État de remplacement pour les visuels manquants (hero sans photo, galerie
    avant/après vide) : un tracé de plan d'architecte en trait fin turquoise
    plutôt qu'un bloc gris inerte. Reprend le vocabulaire du logo (contour +
    cotes) pour que l'absence de photo réelle reste sur la marque plutôt que
    de lire comme un bug.
--}}
<div class="relative flex h-full w-full items-center justify-center overflow-hidden bg-navy-tint">
    <svg class="absolute inset-0 h-full w-full opacity-[0.35]" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
        <defs>
            <pattern id="blueprint-grid" width="32" height="32" patternUnits="userSpaceOnUse">
                <path d="M32 0H0V32" fill="none" stroke="#9AA3AE" stroke-width="0.5" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#blueprint-grid)" />
    </svg>

    <svg viewBox="0 0 200 160" class="relative h-2/3 w-2/3 max-w-xs" fill="none" stroke="#40BBC9" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M20 140V40l60-30 60 30v100" />
        <path d="M20 140h120" />
        <path d="M80 140V90h30v50" />
        <path d="M118 90a30 30 0 0 1 0 50" stroke-dasharray="2 5" />
        <path d="M20 20v-8M140 20v-8M20 12h120" />
        <path d="M8 40v100M0 40h8M0 140h8" />
    </svg>

    @if($label)
        <span class="absolute bottom-4 left-1/2 -translate-x-1/2 text-xs font-medium uppercase tracking-wide text-navy/50">
            {{ $label }}
        </span>
    @endif
</div>
