@props(['settings'])

<footer class="bg-navy-deep text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-4">
        <div>
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/logo-white.png') }}" alt="CONFOR'INO — Rénovation, agencement intérieur, accessibilité" class="h-12 w-auto">
            </a>
            <p class="mt-4 text-sm text-white/70">
                Rénovation intérieure, agencement cuisine &amp; salle de bain et adaptation PMR à domicile,
                basée à {{ $settings->address_city }}.
            </p>
        </div>

        <div>
            <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-turquoise">Coordonnées</h2>
            <ul class="mt-4 space-y-2 text-sm text-white/80">
                <li>{{ $settings->address_street }}, {{ $settings->address_postal_code }} {{ $settings->address_city }}</li>
                <li><a href="tel:{{ preg_replace('/\s+/', '', $settings->call_tracking_phone ?: $settings->phone) }}" class="hover:text-turquoise">{{ $settings->call_tracking_phone ?: $settings->phone }}</a></li>
                <li><a href="mailto:{{ $settings->email }}" class="hover:text-turquoise">{{ $settings->email }}</a></li>
                <li>{{ $settings->opening_hours }}</li>
            </ul>
        </div>

        <div>
            <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-turquoise">Prestations</h2>
            <ul class="mt-4 space-y-2 text-sm text-white/80">
                @foreach(\App\Models\Service::query()->active()->ordered()->get() as $service)
                    <li><a href="{{ route('services.show', $service->slug) }}" class="hover:text-turquoise">{{ $service->title }}</a></li>
                @endforeach
                <li><a href="{{ route('cities.index') }}" class="hover:text-turquoise">Zones d'intervention</a></li>
            </ul>
        </div>

        <div>
            <h2 class="font-display text-sm font-semibold uppercase tracking-wide text-turquoise">Informations</h2>
            <ul class="mt-4 space-y-2 text-sm text-white/80">
                <li><a href="{{ route('page.show', 'a-propos') }}" class="hover:text-turquoise">À propos</a></li>
                <li><a href="{{ route('page.show', 'mentions-legales') }}" class="hover:text-turquoise">Mentions légales</a></li>
                <li><a href="{{ route('page.show', 'politique-de-confidentialite') }}" class="hover:text-turquoise">Politique de confidentialité</a></li>
                <li><a href="{{ route('page.show', 'protection-du-consommateur') }}" class="hover:text-turquoise">Protection du consommateur</a></li>
                <li><a href="{{ route('page.show', 'conditions-generales-de-vente') }}" class="hover:text-turquoise">Conditions générales de vente</a></li>
                <li><a href="{{ route('page.show', 'contact') }}" class="hover:text-turquoise">Contact</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 py-5 text-center text-xs text-white/50">
        &copy; {{ date('Y') }} CONFOR'INO — SARL. Tous droits réservés.
    </div>
</footer>
