@php
    $heading = $block->get('heading');
    $subheading = $block->get('subheading');
    $image = $block->get('image');
    $ctaLabel = $block->get('cta_label');
    $ctaUrl = $block->get('cta_url');
@endphp

<section class="border-b border-stone/20">
    <div class="mx-auto grid max-w-7xl items-stretch gap-0 md:grid-cols-2">
        <div class="order-2 aspect-[4/3] overflow-hidden bg-navy-tint md:order-1 md:aspect-auto">
            @if($image)
                <img
                    src="{{ Illuminate\Support\Str::startsWith($image, ['http', '/storage']) ? $image : asset('storage/'.$image) }}"
                    alt="Réalisation CONFOR'INO avant/après"
                    class="h-full w-full object-cover"
                    loading="eager"
                    width="800" height="600"
                >
            @else
                <x-blueprint-pattern label="Photo à venir" />
            @endif
        </div>

        <div class="order-1 flex flex-col justify-center gap-6 px-4 py-14 sm:px-8 md:order-2 md:py-20 lg:px-16">
            <div>
                <x-logo-mark class="mb-6 h-12 w-12" :animated="true" />
                <h1 class="font-display text-3xl font-semibold leading-tight text-navy sm:text-4xl lg:text-5xl">
                    {{ $heading }}
                </h1>
            </div>

            @if($subheading)
                <p class="max-w-md text-lg text-navy/80">{{ $subheading }}</p>
            @endif

            @if($ctaLabel && $ctaUrl)
                <div>
                    <a href="{{ $ctaUrl }}" class="btn-primary">{{ $ctaLabel }}</a>
                </div>
            @endif
        </div>
    </div>
</section>
