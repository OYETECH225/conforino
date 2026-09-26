@php
    $heading = $block->get('heading');
    $items = $block->get('items', []);

    $resolve = fn ($path) => $path
        ? (Illuminate\Support\Str::startsWith($path, ['http', '/storage']) ? $path : asset('storage/'.$path))
        : null;
@endphp

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
    @if($heading)
        <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
    @endif

    @if(!empty($items))
        <div class="mt-10 grid gap-10 md:grid-cols-2">
            @foreach($items as $item)
                <x-before-after-slider
                    :before="$resolve($item['before_image'] ?? null)"
                    :after="$resolve($item['after_image'] ?? null)"
                    :caption="$item['caption'] ?? null"
                />
            @endforeach
        </div>
    @else
        {{-- État vide honnête plutôt qu'une section qui disparaît silencieusement :
             on affiche le motif de plan plutôt que d'inventer un faux chantier. --}}
        <div class="mt-10 grid gap-10 md:grid-cols-2">
            @foreach([1, 2] as $placeholder)
                <div class="aspect-[4/3] rounded-sm sm:aspect-[16/10]">
                    <x-blueprint-pattern label="Réalisation à venir" />
                </div>
            @endforeach
        </div>
        <p class="mt-6 text-sm text-navy/60">
            Nos premiers chantiers avant/après seront bientôt publiés ici.
        </p>
    @endif
</section>
