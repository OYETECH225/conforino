@php $heading = $block->get('heading'); $intro = $block->get('intro'); @endphp

<section class="bg-navy-deep py-16 text-white" id="devis">
    <div class="mx-auto grid max-w-5xl gap-10 px-4 sm:px-6 md:grid-cols-2 md:items-start">
        <div>
            @if($heading)
                <h2 class="font-display text-2xl font-semibold sm:text-3xl">{{ $heading }}</h2>
            @endif
            @if($intro)
                <p class="mt-4 max-w-md text-white/75">{{ $intro }}</p>
            @endif
            <ul class="mt-8 space-y-3 text-sm text-white/80">
                <li class="flex items-center gap-2"><x-brand-icon name="shield" class="h-5 w-5 text-turquoise" /> Garantie décennale &amp; RC professionnelle</li>
                <li class="flex items-center gap-2"><x-brand-icon name="check" class="h-5 w-5 text-turquoise" /> Devis gratuit, sans engagement</li>
                <li class="flex items-center gap-2"><x-brand-icon name="clock" class="h-5 w-5 text-turquoise" /> Réponse sous 48h ouvrées</li>
            </ul>
        </div>

        <div class="rounded-sm bg-white p-6 sm:p-8">
            @livewire('contact-form')
        </div>
    </div>
</section>
