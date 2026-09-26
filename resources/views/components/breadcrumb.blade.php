@props(['items'])

{{-- Fil d'Ariane visible + balisé (le JSON-LD BreadcrumbList est généré séparément
     dans le <head> par SchemaBuilder::breadcrumbs() à partir des mêmes $items). --}}
<nav aria-label="Fil d'Ariane" class="border-b border-stone/20 bg-navy-tint">
    <ol class="mx-auto flex max-w-7xl flex-wrap items-center gap-1 px-4 py-3 text-sm text-navy/70 sm:px-6">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-1">
                @if(!$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-turquoise-dark hover:underline">{{ $item['name'] }}</a>
                    <span aria-hidden="true" class="mx-1 text-stone">/</span>
                @else
                    <span aria-current="page" class="font-medium text-navy">{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
