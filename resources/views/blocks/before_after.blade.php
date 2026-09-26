@php
    $heading = $block->get('heading');
    $items = $block->get('items', []);

    $resolve = fn ($path) => $path
        ? (Illuminate\Support\Str::startsWith($path, ['http', '/storage']) ? $path : asset('storage/'.$path))
        : null;
@endphp

@if(!empty($items))
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        @if($heading)
            <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
        @endif

        <div class="mt-10 grid gap-10 md:grid-cols-2">
            @foreach($items as $item)
                <x-before-after-slider
                    :before="$resolve($item['before_image'] ?? null)"
                    :after="$resolve($item['after_image'] ?? null)"
                    :caption="$item['caption'] ?? null"
                />
            @endforeach
        </div>
    </section>
@endif
