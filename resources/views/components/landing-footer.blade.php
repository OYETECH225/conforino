@props(['settings'])

{{-- Pied de page réduit aux mentions légalement obligatoires (pas de plan du
     site ni de liens vers les autres pages) ; les liens légaux s'ouvrent dans
     un nouvel onglet pour ne pas faire quitter la page de conversion. --}}
<footer class="border-t border-stone/20 bg-navy-tint">
    <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-x-6 gap-y-2 px-4 py-6 text-xs text-navy/60 sm:px-6">
        <p>&copy; {{ date('Y') }} CONFOR'INO — SARL. {{ $settings->address_city }} ({{ $settings->address_postal_code }}).</p>
        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
            <a href="{{ route('page.show', 'mentions-legales') }}" target="_blank" rel="noopener" class="hover:text-turquoise-dark">Mentions légales</a><span>·</span>
            <a href="{{ route('page.show', 'politique-de-confidentialite') }}" target="_blank" rel="noopener" class="hover:text-turquoise-dark">Politique de confidentialité</a>
        </div>
    </div>
</footer>
