@props(['eyebrow' => null, 'heading' => null, 'intro' => null, 'component' => 'contact-form', 'maxWidth' => 'max-w-3xl'])

<div class="mx-auto {{ $maxWidth }} px-4 sm:px-6">
    <div class="bg-white p-6 shadow-[0_20px_40px_-24px_rgba(30,54,100,0.25)] sm:p-10">
        <div class="mx-auto h-0.5 w-full max-w-xs bg-turquoise"></div>

        <div class="mt-6 text-center">
            @if($eyebrow)
                <p class="text-xs font-semibold uppercase tracking-wide text-navy/60">{{ $eyebrow }}</p>
            @endif
            @if($heading)
                <h2 class="mt-2 font-display text-2xl font-bold text-navy sm:text-3xl">{{ $heading }}</h2>
            @endif
            @if($intro)
                <p class="mx-auto mt-3 max-w-md text-[15px] text-navy/75">{{ $intro }}</p>
            @endif
        </div>

        <div class="mt-8">
            @livewire($component)
        </div>
    </div>
</div>
