@php $heading = $block->get('heading'); $intro = $block->get('intro'); @endphp

{{-- Fond clair (et non navy-deep) : le footer est déjà sombre juste en
     dessous, deux sections sombres consécutives se confondaient l'une
     dans l'autre sans frontière visible. --}}
<section class="bg-navy-tint py-16" id="devis">
    <div class="mx-auto grid max-w-5xl gap-10 px-4 sm:px-6 md:grid-cols-2 md:items-start">
        <div>
            @if($heading)
                <h2 class="font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
            @endif
            @if($intro)
                <p class="mt-4 max-w-md text-navy/75">{{ $intro }}</p>
            @endif
            <ul class="mt-8 space-y-3 text-sm text-navy/80">
                <li class="flex items-center gap-2"><x-brand-icon name="shield" class="h-5 w-5 text-turquoise-dark" /> Garantie décennale &amp; RC professionnelle</li>
                <li class="flex items-center gap-2"><x-brand-icon name="check" class="h-5 w-5 text-turquoise-dark" /> Devis gratuit, sans engagement</li>
                <li class="flex items-center gap-2"><x-brand-icon name="clock" class="h-5 w-5 text-turquoise-dark" /> Réponse sous 48h ouvrées</li>
            </ul>
        </div>

        <div class="relative border border-stone/20 border-t-4 border-t-turquoise bg-white p-6 shadow-[0_20px_40px_-24px_rgba(30,54,100,0.25)] sm:p-8">
            @livewire('contact-form')
        </div>
    </div>
</section>
