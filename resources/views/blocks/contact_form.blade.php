@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $wizard = (bool) $block->get('wizard');
@endphp

<section class="bg-navy-tint py-16" id="devis">
    <x-contact-card
        :eyebrow="$eyebrow"
        :heading="$heading"
        :intro="$intro"
        :component="$wizard ? 'contact-wizard' : 'contact-form'"
        :max-width="$wizard ? 'max-w-2xl' : 'max-w-3xl'"
    />
</section>
