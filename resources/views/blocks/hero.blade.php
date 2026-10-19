@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $subheading = $block->get('subheading');
    $proofLine = $block->get('proof_line');
    $image = $block->get('image');
    $beforeImage = $block->get('before_image');
    $ctaLabel = $block->get('cta_label');
    $ctaUrl = $block->get('cta_url');
    $cta2Label = $block->get('cta2_label');
    $cta2Url = $block->get('cta2_url');
    $stripIcon = $block->get('strip_icon');
    $stripText = $block->get('strip_text');
    $stripBadge = $block->get('strip_badge');

    $resolveUrl = fn ($path) => Illuminate\Support\Str::startsWith($path, ['http', '/storage']) ? $path : asset('storage/'.$path);
@endphp

<section class="border-b border-stone/20 bg-white">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 md:py-20 lg:gap-16 lg:px-8">
        <div class="reveal flex flex-col gap-6">
            @if($eyebrow)
                <p class="inline-flex w-fit items-center gap-2 rounded-full bg-navy-tint px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-navy/70 sm:text-sm">
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-turquoise"></span>
                    {{ $eyebrow }}
                </p>
            @endif

            <h1 class="cote font-display text-3xl font-bold leading-tight text-navy sm:text-4xl lg:text-5xl">
                {{ $heading }}
            </h1>

            @if($subheading)
                <p class="max-w-md text-lg text-navy/80">{{ $subheading }}</p>
            @endif

            @if(($ctaLabel && $ctaUrl) || ($cta2Label && $cta2Url))
                <div class="flex flex-wrap gap-3">
                    @if($ctaLabel && $ctaUrl)
                        <a href="{{ $ctaUrl }}" class="btn-primary">{{ $ctaLabel }} →</a>
                    @endif
                    @if($cta2Label && $cta2Url)
                        <a href="{{ $cta2Url }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-navy-tint px-6 font-medium text-navy transition-colors hover:bg-navy-tint/70" style="min-height:44px">
                            {{ $cta2Label }}
                        </a>
                    @endif
                </div>
            @endif

            @if($proofLine)
                <p class="flex items-center gap-2 text-sm text-navy/70">
                    <x-brand-icon name="check" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                    {{ $proofLine }}
                </p>
            @endif
        </div>

        <div class="reveal reveal-delay-2">
            @if($image)
                <x-before-after-slider
                    :after="$resolveUrl($image)"
                    :before="$beforeImage ? $resolveUrl($beforeImage) : null"
                    :hide-handle="true"
                />
                @if($stripText || $stripBadge)
                    <div class="flex items-center justify-between gap-3 bg-navy-deep px-4 py-3 text-sm text-white">
                        <span class="flex items-center gap-2">
                            @if($stripIcon)
                                <x-brand-icon :name="$stripIcon" class="h-5 w-5 shrink-0 text-turquoise" />
                            @endif
                            {{ $stripText }}
                        </span>
                        @if($stripBadge)
                            <span class="shrink-0 text-xs font-semibold uppercase tracking-wide text-turquoise">{{ $stripBadge }}</span>
                        @endif
                    </div>
                @endif
            @else
                <div class="aspect-[4/3] overflow-hidden rounded-sm bg-navy-tint sm:aspect-[16/10]">
                    <x-blueprint-pattern label="Photo à venir" />
                </div>
            @endif
        </div>
    </div>
</section>
