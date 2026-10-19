@props(['eyebrow' => null, 'align' => 'left'])

<div class="reveal {{ $align === 'center' ? 'text-center' : '' }}">
    @if($eyebrow)
        <p class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-navy/60 {{ $align === 'center' ? 'justify-center' : '' }}">
            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-turquoise"></span>
            {{ $eyebrow }}
        </p>
    @endif
    <h2 class="{{ $align === 'center' ? 'cote-center' : 'cote' }} mt-2 font-display text-2xl font-bold text-navy sm:text-3xl">
        {{ $slot }}
        @if($align === 'center')<span class="tick-right"></span>@endif
    </h2>
</div>
