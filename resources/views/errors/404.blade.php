<x-layout
    :seo="['title' => 'Page introuvable | CONFOR\'INO', 'robots' => 'noindex,follow']"
    :breadcrumbs="[]"
    :show-breadcrumb="false"
>
    <section class="mx-auto max-w-3xl px-4 py-24 text-center sm:px-6">
        <x-logo-mark class="mx-auto h-14 w-14" />

        <p class="cote mx-auto mt-8 inline-block font-serif text-5xl font-medium text-turquoise">404</p>

        <h1 class="mt-6 font-display text-2xl font-semibold text-navy sm:text-3xl">
            Cette page n'existe pas ou plus
        </h1>
        <p class="mt-4 text-lg text-navy/75">
            Le lien que vous avez suivi est peut-être incorrect, ou la page a été déplacée.
            Voici quelques pages qui pourraient vous intéresser :
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ url('/') }}" class="btn-primary">Retour à l'accueil</a>
            <a href="{{ route('services.index') }}" class="btn-outline">Nos prestations</a>
            <a href="{{ route('page.show', 'contact') }}" class="btn-outline">Nous contacter</a>
        </div>
    </section>
</x-layout>
