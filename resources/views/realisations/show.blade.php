<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6">
        <h1 class="font-display text-3xl font-semibold text-navy sm:text-4xl">{{ $realisation->title }}</h1>

        <div class="mt-8">
            <x-before-after-slider
                :before="$realisation->beforeUrl()"
                :after="$realisation->afterUrl()"
                :before-alt="$realisation->title.' — avant travaux'"
                :after-alt="$realisation->title.' — après travaux'"
            />
        </div>

        <div class="mt-10 grid gap-10 md:grid-cols-3">
            <div class="md:col-span-2">
                <h2 class="cote font-display text-xl font-semibold text-navy">Le projet</h2>
                @if($realisation->description)
                    <p class="mt-6 text-[15px] leading-relaxed text-navy/80">{{ $realisation->description }}</p>
                @endif

                @if($realisation->service)
                    <p class="mt-6">
                        <a href="{{ route('services.show', $realisation->service->slug) }}" class="font-medium text-turquoise-dark underline">
                            Voir la prestation : {{ $realisation->service->title }}
                        </a>
                    </p>
                @endif
            </div>

            <div class="space-y-4 border-l border-stone/25 pl-6 text-sm">
                @if($realisation->city)
                    <div><span class="block text-stone">Ville</span><span class="text-navy">{{ $realisation->city->name }}</span></div>
                @endif
                @if($realisation->surface)
                    <div><span class="block text-stone">Surface</span><span class="text-navy">{{ $realisation->surface }}</span></div>
                @endif
                @if($realisation->duration)
                    <div><span class="block text-stone">Durée des travaux</span><span class="text-navy">{{ $realisation->duration }}</span></div>
                @endif
            </div>
        </div>

        <div class="mt-14 text-center">
            <a href="{{ route('page.show', 'contact') }}" class="btn-primary">Un projet similaire ? Demandez votre devis</a>
        </div>
    </section>
</x-layout>
