<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <h1 class="font-display text-3xl font-semibold text-navy sm:text-4xl">Zones d'intervention</h1>
        <p class="mt-4 max-w-2xl text-lg text-navy/75">
            CONFOR'INO intervient à Argenteuil et dans les communes voisines du Val-d'Oise. Chaque ville
            bénéficie d'une équipe qui connaît le bâti local et les contraintes d'accès spécifiques au secteur.
        </p>

        <div class="mt-12 divide-y divide-stone/20 border-y border-stone/20">
            @foreach($cities as $city)
                <div id="{{ $city->slug }}" class="scroll-mt-24 py-8">
                    <h2 class="font-display text-xl font-semibold text-navy">{{ $city->name }}</h2>
                    @if($city->description_short)
                        <p class="mt-2 max-w-2xl text-[15px] text-navy/75">{{ $city->description_short }}</p>
                    @endif

                    @if($city->services->isNotEmpty())
                        <ul class="mt-4 flex flex-wrap gap-3">
                            @foreach($city->services as $service)
                                <li>
                                    <a href="{{ route('services.show', $service->slug.'-'.$city->slug) }}" class="inline-flex items-center gap-2 rounded-sm border border-stone/30 px-4 py-2 text-sm text-navy hover:border-turquoise" style="min-height:44px">
                                        <x-brand-icon :name="$service->icon" class="h-4 w-4 text-turquoise-dark" />
                                        {{ $service->title }} à {{ $city->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
</x-layout>
