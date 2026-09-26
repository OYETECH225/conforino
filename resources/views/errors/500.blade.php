<x-layout
    :seo="['title' => 'Erreur technique | CONFOR\'INO', 'robots' => 'noindex,follow']"
    :breadcrumbs="[]"
    :show-breadcrumb="false"
>
    <section class="mx-auto max-w-3xl px-4 py-24 text-center sm:px-6">
        <x-logo-mark class="mx-auto h-14 w-14" />

        <h1 class="mt-8 font-display text-2xl font-semibold text-navy sm:text-3xl">
            Une erreur technique est survenue
        </h1>
        <p class="mt-4 text-lg text-navy/75">
            Nos équipes ont été informées. Merci de réessayer dans quelques instants, ou de nous
            contacter directement si le problème persiste.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary">Retour à l'accueil</a>
            <a href="{{ route('page.show', 'contact') }}" class="btn-outline">Nous contacter</a>
        </div>
    </section>
</x-layout>
