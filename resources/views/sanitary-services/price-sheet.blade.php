<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">

    <section class="border-b border-stone/20 bg-white py-14">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            <x-section-heading eyebrow="Transparence des prix">Fiche tarifaire — Plomberie &amp; installation sanitaire</x-section-heading>
            <p class="mt-4 max-w-2xl text-lg text-navy/75">
                Tous nos prix sont connus à l'avance, déplacement inclus dans notre zone habituelle d'intervention, et aucun supplément n'est appliqué sans votre accord préalable.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-14 sm:px-6">
        <div class="overflow-x-auto border border-stone/20">
            <table class="w-full min-w-[560px] border-collapse text-left">
                <thead>
                    <tr class="bg-navy-tint">
                        <th class="px-5 py-4 font-display text-sm font-bold uppercase tracking-wide text-navy">Prestation</th>
                        <th class="px-5 py-4 font-display text-sm font-bold uppercase tracking-wide text-navy">Durée indicative</th>
                        <th class="px-5 py-4 text-right font-display text-sm font-bold uppercase tracking-wide text-navy">Prix TTC</th>
                        <th class="px-5 py-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr class="reveal border-t border-stone/15">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <x-brand-icon :name="$service->icon" class="h-5 w-5 shrink-0 text-turquoise-dark" />
                                    <span class="font-medium text-navy">{{ $service->title }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-[15px] text-navy/70">{{ $service->duration_label ?: '—' }}</td>
                            <td class="px-5 py-4 text-right font-serif text-xl font-medium text-navy">{{ $service->priceLabel() }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('sanitary-services.show', $service->slug) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-turquoise-dark">
                                    Détails <span aria-hidden="true">→</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="mt-6 text-xs text-navy/60">
            Prix pour une intervention standard, hors options éventuelles. Certaines prestations peuvent être éligibles à la TVA réduite sous conditions d'application ; se référer à la fiche de chaque prestation. Toute complication imprévue constatée sur place peut faire l'objet d'un devis complémentaire, soumis à votre accord avant exécution.
        </p>
    </section>

    @php
        // Construit hors de l'attribut du composant : Blade ne compile pas un
        // attribut contenant des guillemets échappés et le recopie tel quel.
        $contactBlock = new \App\Models\Block(['type' => 'contact_form', 'data' => [
            'eyebrow' => 'Devis rapide & gratuit',
            'heading' => 'Une prestation à demander ?',
            'intro' => 'Complétez le formulaire en précisant la prestation souhaitée, ou appelez-nous directement.',
        ]]);
    @endphp
    <x-render-blocks :blocks="collect([$contactBlock])" />
</x-layout>
