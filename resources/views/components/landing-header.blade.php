@props(['settings'])

{{-- Header volontairement sans navigation ni lien cliquable sur le logo :
     une page de destination Ads ne doit offrir qu'une seule sortie possible
     (le formulaire de devis), pas un chemin de retour vers le reste du site. --}}
<header class="border-b border-stone/30 bg-white">
    <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
        <img src="{{ $settings->logo_color_path ? Illuminate\Support\Facades\Storage::disk('public')->url($settings->logo_color_path) : asset('images/logo-color.png') }}" alt="CONFOR'INO — Rénovation, agencement intérieur, accessibilité" class="h-10 w-auto sm:h-12">

        <a href="tel:{{ preg_replace('/\s+/', '', $settings->call_tracking_phone ?: $settings->phone) }}" class="flex items-center gap-2 font-display text-[15px] font-semibold text-navy sm:text-base">
            <x-brand-icon name="phone" class="h-5 w-5 shrink-0 text-turquoise-dark" />
            <span class="hidden sm:inline">{{ $settings->call_tracking_phone ?: $settings->phone }}</span>
            <span class="sm:hidden">Appeler</span>
        </a>
    </div>
</header>
