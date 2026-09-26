@php
    $heroTitle = $city ? "{$service->title} à {$city->name}" : $service->title;
    $heroSubtitle = $city
        ? ($pivot->local_intro ?: $service->short_description)
        : $service->short_description;
@endphp

<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="border-b border-stone/20">
        <div class="mx-auto grid max-w-7xl items-stretch gap-0 md:grid-cols-2">
            <div class="order-2 aspect-[4/3] overflow-hidden bg-navy-tint md:order-1 md:aspect-auto">
                @if($service->imageUrl())
                    <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}@if($city) à {{ $city->name }}@endif" class="h-full w-full object-cover" loading="eager">
                @endif
            </div>
            <div class="order-1 flex flex-col justify-center gap-6 px-4 py-14 sm:px-8 md:order-2 md:py-20 lg:px-16">
                <x-brand-icon :name="$service->icon" class="h-10 w-10 text-turquoise-dark" />
                <h1 class="font-display text-3xl font-semibold leading-tight text-navy sm:text-4xl">{{ $heroTitle }}</h1>
                @if($heroSubtitle)
                    <p class="max-w-md text-lg text-navy/80">{{ $heroSubtitle }}</p>
                @endif
                <div><a href="{{ route('page.show', 'contact') }}" class="btn-primary">Devis gratuit</a></div>
            </div>
        </div>
    </section>

    @if($service->long_description)
        <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">Ce que nous faisons</h2>
            <div class="prose mt-6 max-w-none prose-headings:font-display prose-headings:text-navy prose-a:text-turquoise-dark">
                {!! $service->long_description !!}
            </div>
        </section>
    @endif

    <section class="bg-navy-deep py-16 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <h2 class="font-display text-2xl font-semibold sm:text-3xl"><span class="cote">Pourquoi CONFOR'INO</span></h2>
            <div class="mt-12 grid gap-10 sm:grid-cols-3">
                <div>
                    <p class="font-serif text-4xl font-medium text-turquoise">13 ans</p>
                    <p class="mt-2 text-[15px] text-white/75">d'expérience en rénovation et agencement</p>
                </div>
                <div>
                    <p class="font-serif text-4xl font-medium text-turquoise">200+</p>
                    <p class="mt-2 text-[15px] text-white/75">projets et clients accompagnés</p>
                </div>
                <div>
                    <p class="font-serif text-4xl font-medium text-turquoise">Décennale</p>
                    <p class="mt-2 text-[15px] text-white/75">garantie &amp; RC professionnelle</p>
                </div>
            </div>
        </div>
    </section>

    @if($realisations->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">Avant / après</h2>
            <div class="mt-10 grid gap-10 md:grid-cols-2">
                @foreach($realisations as $realisation)
                    <x-before-after-slider :before="$realisation->beforeUrl()" :after="$realisation->afterUrl()" :caption="$realisation->title" />
                @endforeach
            </div>
        </section>
    @endif

    @if($otherCities->isNotEmpty())
        <section class="bg-navy-tint py-16">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">
                    Zones desservies {{ $city ? 'autour de '.$city->name : '' }}
                </h2>
                <ul class="mt-8 flex flex-wrap gap-3">
                    @foreach($otherCities as $otherCity)
                        <li>
                            <a href="{{ route('services.show', $service->slug.'-'.$otherCity->slug) }}" class="inline-flex items-center gap-2 rounded-sm border border-stone/30 bg-white px-4 py-2 text-[15px] text-navy hover:border-turquoise" style="min-height:44px">
                                <x-brand-icon name="pin" class="h-4 w-4 text-turquoise-dark" />
                                {{ $service->title }} à {{ $otherCity->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    @if($reviews->isNotEmpty())
        <section class="bg-turquoise-tint py-16">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">Nos clients s'expriment</h2>
                <div class="mt-10 grid gap-8 md:grid-cols-2">
                    @foreach($reviews as $review)
                        <figure class="border-l-2 border-turquoise pl-6">
                            <blockquote class="font-serif text-lg italic leading-relaxed text-navy">« {{ $review->text }} »</blockquote>
                            <figcaption class="mt-3 text-sm text-navy/70">{{ $review->author_name }}@if($review->cityName()), {{ $review->cityName() }}@endif</figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-5xl px-4 py-14 text-center sm:px-6">
        <p class="text-navy/80">Une question sur ce projet ?</p>
        <a href="{{ route('page.show', 'faq') }}" class="mt-2 inline-block font-medium text-turquoise-dark underline">Consulter la FAQ</a>
    </section>

    <section class="bg-navy-deep py-16 text-white" id="devis">
        <div class="mx-auto grid max-w-5xl gap-10 px-4 sm:px-6 md:grid-cols-2 md:items-start">
            <div>
                <h2 class="font-display text-2xl font-semibold sm:text-3xl">Recevez votre devis gratuit</h2>
                <p class="mt-4 max-w-md text-white/75">
                    Réponse sous 48h ouvrées, sans engagement.
                </p>
            </div>
            <div class="rounded-sm bg-white p-6 sm:p-8">
                @livewire('contact-form')
            </div>
        </div>
    </section>
</x-layout>
