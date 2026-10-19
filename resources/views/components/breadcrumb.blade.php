@props(['items', 'badges' => []])

{{-- Fil d'Ariane visible + balisé (le JSON-LD BreadcrumbList est généré séparément
     dans le <head> par SchemaBuilder::breadcrumbs() à partir des mêmes $items). --}}
<nav aria-label="Fil d'Ariane" class="border-b border-stone/20 bg-navy-tint">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6">
        <ol class="flex flex-wrap items-center gap-1 text-sm text-navy/70">
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

        @if(!empty($badges))
            <div class="flex flex-wrap items-center gap-2">
                @foreach($badges as $badge)
                    <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ ($badge['solid'] ?? false) ? 'bg-navy-deep text-white' : 'border border-turquoise-dark/40 bg-white text-turquoise-dark' }}">
                        @if(!empty($badge['icon']))
                            <x-brand-icon :name="$badge['icon']" class="h-3.5 w-3.5 shrink-0" />
                        @endif
                        {{ $badge['text'] }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</nav>
