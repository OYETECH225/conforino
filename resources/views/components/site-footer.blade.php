@props(['settings'])

<footer class="bg-navy-deep text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-4">
        <div>
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ $settings->logo_white_path ? Illuminate\Support\Facades\Storage::disk('public')->url($settings->logo_white_path) : asset('images/logo-white.png') }}" alt="CONFOR'INO — Rénovation, agencement intérieur, accessibilité" class="h-12 w-auto">
            </a>
            <p class="mt-4 text-sm text-white/70">{{ $settings->footer_tagline }}</p>
            <p class="mt-4 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-turquoise">
                <x-brand-icon name="ruler" class="h-4 w-4 shrink-0" />
                {{ $settings->footer_artisanat_label }}
            </p>
        </div>

        <div>
            <h2 class="flex items-center gap-2 font-display text-sm font-semibold uppercase tracking-wide text-white">
                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-turquoise"></span>Prestations
            </h2>
            <ul class="mt-4 space-y-2 text-sm text-white/80">
                <li><a href="{{ route('sanitary-services.index') }}" class="hover:text-turquoise">Plomberie &amp; installation sanitaire</a></li>
                @foreach(\App\Models\Service::query()->active()->ordered()->get() as $service)
                    <li><a href="{{ route('services.show', $service->slug) }}" class="hover:text-turquoise">{{ $service->title }}</a></li>
                @endforeach
                <li><a href="{{ route('cities.index') }}" class="hover:text-turquoise">Zones d'intervention</a></li>
            </ul>
        </div>

        <div>
            <h2 class="flex items-center gap-2 font-display text-sm font-semibold uppercase tracking-wide text-white">
                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-turquoise"></span>Coordonnées &amp; horaires
            </h2>
            <ul class="mt-4 space-y-3 text-sm text-white/80">
                <li class="flex items-start gap-2"><x-brand-icon name="pin" class="mt-0.5 h-4 w-4 shrink-0 text-turquoise" /> {{ $settings->address_street }}, {{ $settings->address_postal_code }} {{ $settings->address_city }}</li>
                <li class="flex items-start gap-2"><x-brand-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-turquoise" /> {{ $settings->opening_hours }}</li>
                <li class="flex items-center gap-2"><x-brand-icon name="phone" class="h-4 w-4 shrink-0 text-turquoise" /> <a href="tel:{{ preg_replace('/\s+/', '', $settings->call_tracking_phone ?: $settings->phone) }}" class="font-semibold hover:text-turquoise">{{ $settings->call_tracking_phone ?: $settings->phone }}</a></li>
                <li class="flex items-center gap-2"><x-brand-icon name="mail" class="h-4 w-4 shrink-0 text-turquoise" /> <a href="mailto:{{ $settings->email }}" class="hover:text-turquoise">{{ $settings->email }}</a></li>
            </ul>
            <ul class="mt-5 space-y-2 text-sm text-white/80">
                <li><a href="{{ route('page.show', 'a-propos') }}" class="hover:text-turquoise">À propos</a></li>
                <li><a href="{{ route('page.show', 'contact') }}" class="hover:text-turquoise">Contact</a></li>
            </ul>
        </div>

        <div>
            <h2 class="flex items-center gap-2 font-display text-sm font-semibold uppercase tracking-wide text-white">
                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-turquoise"></span>Garanties &amp; normes
            </h2>
            <div class="mt-4 space-y-3">
                <div class="flex items-start gap-3 border border-white/15 bg-white/5 p-3">
                    <x-brand-icon :name="$settings->guarantee_1_icon" class="mt-0.5 h-5 w-5 shrink-0 text-turquoise" />
                    <p class="text-sm text-white/85"><span class="font-semibold text-white">{{ $settings->guarantee_1_title }}</span><br>{{ $settings->guarantee_1_subtitle }}</p>
                </div>
                <div class="flex items-start gap-3 border border-white/15 bg-white/5 p-3">
                    <x-brand-icon :name="$settings->guarantee_2_icon" class="mt-0.5 h-5 w-5 shrink-0 text-turquoise" />
                    <p class="text-sm text-white/85"><span class="font-semibold text-white">{{ $settings->guarantee_2_title }}</span><br>{{ $settings->guarantee_2_subtitle }}</p>
                </div>
                <div class="border-l-4 border-turquoise bg-white/5 p-3">
                    <p class="text-sm text-white/85">{{ $settings->deontology_text }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-6 gap-y-2 px-4 py-5 text-xs text-white/60 sm:px-6">
            <p>&copy; {{ date('Y') }} CONFOR'INO — SARL. Tous droits réservés. {{ $settings->address_city }} ({{ $settings->address_postal_code }}).</p>
            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                <a href="{{ route('page.show', 'mentions-legales') }}" class="hover:text-turquoise">Mentions légales</a><span>·</span>
                <a href="{{ route('page.show', 'politique-de-confidentialite') }}" class="hover:text-turquoise">Politique de confidentialité</a><span>·</span>
                <a href="{{ route('page.show', 'protection-du-consommateur') }}" class="hover:text-turquoise">Protection du consommateur</a><span>·</span>
                <a href="{{ route('page.show', 'conditions-generales-de-vente') }}" class="hover:text-turquoise">CGV</a><span>·</span>
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('reopen-cookie-banner'))" class="hover:text-turquoise">Gérer mes cookies</button>
            </div>
        </div>
    </div>
</footer>
