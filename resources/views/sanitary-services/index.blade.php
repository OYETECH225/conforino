<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    @if($heroBlock)
        <x-render-blocks :blocks="collect([$heroBlock])" />
    @endif

    @if($benefitsBlock)
        <x-render-blocks :blocks="collect([$benefitsBlock])" />
    @endif

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Choisissez votre prestation">Nos prestations à prix fixe</x-section-heading>
            <a href="{{ route('sanitary-services.price-sheet') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                Voir la fiche tarifaire complète <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $index => $service)
                <a href="{{ route('sanitary-services.show', $service->slug) }}" class="reveal reveal-delay-{{ min($index % 5 + 1, 5) }} group flex flex-col border border-stone/20 bg-white transition-colors hover:border-turquoise-dark/50">
                    <div class="relative aspect-[4/3] overflow-hidden bg-navy-tint">
                        @if($service->imageUrl())
                            <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        @else
                            <x-blueprint-pattern />
                        @endif
                        <span class="absolute left-3 top-3 flex h-9 w-9 items-center justify-center bg-white/90">
                            <x-brand-icon :name="$service->icon" class="h-5 w-5 shrink-0 text-turquoise-dark" />
                        </span>
                        <span class="absolute bottom-3 right-3 bg-navy-deep/85 px-3 py-1 font-serif text-lg font-medium text-white">{{ $service->priceLabel() }}</span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="font-display text-lg font-bold text-navy">{{ $service->title }}</h3>
                        <p class="mt-2 flex-1 text-[15px] text-navy/75">{{ $service->short_description }}</p>
                        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                            Demander cette prestation <span aria-hidden="true" class="transition-transform group-hover:translate-x-1">→</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    @if($processBlock)
        <x-render-blocks :blocks="collect([$processBlock])" />
    @endif

    <x-render-blocks :blocks="collect([new \App\Models\Block(['type' => 'contact_form', 'data' => [
        'eyebrow' => 'Demande rapide',
        'heading' => 'Une question, une prestation sur mesure ?',
        'intro' => \"Si votre besoin ne correspond pas exactement à l'une de nos prestations à prix fixe, contactez-nous : nous étudions votre demande et vous répondons rapidement.\",
    ]])])" />
</x-layout>
