<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="border-b border-stone/20 bg-white">
        <div class="mx-auto grid max-w-5xl items-center gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 md:py-20">
            <div class="reveal flex flex-col gap-4">
                <p class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide text-navy/60">
                    <span class="h-px w-6 bg-turquoise"></span>
                    <x-brand-icon :name="$service->icon" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                    Plomberie &amp; installation sanitaire
                </p>
                <h1 class="cote font-display text-3xl font-bold leading-tight text-navy sm:text-4xl">{{ $service->title }}</h1>
                <p class="max-w-xl text-lg text-navy/80">{{ $service->short_description }}</p>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="aspect-[4/3] overflow-hidden bg-navy-tint sm:aspect-[16/11]">
                    @if($service->imageUrl())
                        <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="h-full w-full object-cover" loading="eager">
                    @else
                        <x-blueprint-pattern label="Photo à venir" />
                    @endif
                </div>
                <div class="mt-4 border border-turquoise-dark/30 bg-turquoise-tint px-6 py-5 text-center">
                    <p class="font-serif text-4xl font-medium text-navy">{{ $service->priceLabel() }}</p>
                    @if($service->price_note)
                        <p class="mt-2 text-xs text-navy/60">{{ $service->price_note }}</p>
                    @endif
                    @if($service->duration_label)
                        <p class="mt-3 flex items-center justify-center gap-1.5 text-sm font-semibold text-navy">
                            <x-brand-icon name="clock" class="h-4 w-4 shrink-0 text-turquoise-dark" />
                            {{ $service->duration_label }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6">
        <div class="grid gap-10 md:grid-cols-2">
            @if(!empty($service->included_items))
                <div class="reveal">
                    <h2 class="font-display text-lg font-bold text-navy">Ce qui est inclus</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach($service->included_items as $item)
                            <li class="flex items-start gap-2 text-[15px] text-navy/80">
                                <x-brand-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-dark" />
                                {{ is_array($item) ? ($item['item'] ?? '') : $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($service->client_provides))
                <div class="reveal reveal-delay-2 border-l-4 border-turquoise bg-navy-tint p-5">
                    <h2 class="font-display text-lg font-bold text-navy">Ce que vous devez fournir</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach($service->client_provides as $item)
                            <li class="flex items-start gap-2 text-[15px] text-navy/80">
                                <x-brand-icon name="ruler" class="mt-0.5 h-4 w-4 shrink-0 text-turquoise-dark" />
                                {{ is_array($item) ? ($item['item'] ?? '') : $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        @if(!empty($service->excluded_items))
            <div class="reveal mt-10">
                <h2 class="font-display text-lg font-bold text-navy">Ce qui n'est pas inclus</h2>
                <ul class="mt-4 space-y-2.5">
                    @foreach($service->excluded_items as $item)
                        <li class="flex items-start gap-2 text-[15px] text-navy/70">
                            <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-navy/40"></span>
                            {{ is_array($item) ? ($item['item'] ?? '') : $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($service->extra_note)
            <p class="reveal mt-10 border-l-4 border-stone/30 pl-4 text-[15px] text-navy/70">{{ $service->extra_note }}</p>
        @endif

        <p class="reveal mt-10 flex items-center gap-2 text-sm text-navy/70">
            <x-brand-icon name="shield" class="h-4 w-4 shrink-0 text-turquoise-dark" />
            Intervention réalisée par un professionnel qualifié, couverte par notre assurance responsabilité civile professionnelle et notre garantie décennale (Groupama).
        </p>
    </section>

    <x-render-blocks :blocks="collect([new \App\Models\Block(['type' => 'contact_form', 'data' => [
        'eyebrow' => 'Prix connu à l\'avance, sans surprise',
        'heading' => 'Demander : '.$service->title,
        'intro' => \"Complétez le formulaire ou appelez-nous directement : nous confirmons votre rendez-vous rapidement, sans supplément sans votre accord préalable.\",
    ]])])" />
</x-layout>
