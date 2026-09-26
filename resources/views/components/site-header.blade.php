@props(['navServices' => [], 'settings'])

<header class="border-b border-stone/30 bg-white" x-data="{ open: false }">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <x-logo-mark class="h-9 w-9" />
            <span class="font-display text-lg font-semibold text-navy">CONFOR'INO</span>
        </a>

        <nav class="hidden items-center gap-6 lg:flex" aria-label="Navigation principale">
            <div class="group relative">
                <a href="{{ route('services.index') }}" class="font-display text-[15px] font-medium text-navy hover:text-turquoise-dark">
                    Services
                </a>
                <div class="invisible absolute left-0 top-full z-20 w-72 rounded-sm border border-stone/20 bg-white py-2 opacity-0 shadow-lg transition group-hover:visible group-hover:opacity-100">
                    @foreach($navServices as $service)
                        <a href="{{ route('services.show', $service->slug) }}" class="block px-4 py-2 text-[15px] text-navy hover:bg-navy-tint">
                            {{ $service->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('realisations.index') }}" class="font-display text-[15px] font-medium text-navy hover:text-turquoise-dark">Réalisations</a>
            <a href="{{ route('reviews.index') }}" class="font-display text-[15px] font-medium text-navy hover:text-turquoise-dark">Avis clients</a>
            <a href="{{ route('cities.index') }}" class="font-display text-[15px] font-medium text-navy hover:text-turquoise-dark">Zones d'intervention</a>
            <a href="{{ route('page.show', 'faq') }}" class="font-display text-[15px] font-medium text-navy hover:text-turquoise-dark">FAQ</a>
        </nav>

        <div class="hidden items-center gap-4 lg:flex">
            <a href="tel:{{ preg_replace('/\s+/', '', $settings->call_tracking_phone ?: $settings->phone) }}" class="flex items-center gap-2 font-display text-[15px] font-medium text-navy">
                <x-brand-icon name="phone" class="h-5 w-5 text-turquoise-dark" />
                {{ $settings->call_tracking_phone ?: $settings->phone }}
            </a>
            <a href="{{ route('page.show', 'contact') }}" class="btn-primary">Devis gratuit</a>
        </div>

        <button @click="open = !open" type="button" class="lg:hidden" style="min-height:44px;min-width:44px" aria-label="Ouvrir le menu" :aria-expanded="open">
            <svg viewBox="0 0 24 24" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak class="border-t border-stone/20 lg:hidden">
        <nav class="flex flex-col px-4 py-3" aria-label="Navigation mobile">
            <a href="{{ route('services.index') }}" class="py-3 font-display text-navy" style="min-height:44px">Services</a>
            @foreach($navServices as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="py-2 pl-4 text-[15px] text-navy" style="min-height:44px">{{ $service->title }}</a>
            @endforeach
            <a href="{{ route('realisations.index') }}" class="py-3 font-display text-navy" style="min-height:44px">Réalisations</a>
            <a href="{{ route('reviews.index') }}" class="py-3 font-display text-navy" style="min-height:44px">Avis clients</a>
            <a href="{{ route('cities.index') }}" class="py-3 font-display text-navy" style="min-height:44px">Zones d'intervention</a>
            <a href="{{ route('page.show', 'faq') }}" class="py-3 font-display text-navy" style="min-height:44px">FAQ</a>
            <a href="{{ route('page.show', 'contact') }}" class="btn-primary mt-3 justify-center">Devis gratuit</a>
        </nav>
    </div>
</header>
