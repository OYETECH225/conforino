@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $searchable = (bool) $block->get('searchable');
    $groups = $block->get('groups', []);
    $items = $block->get('items', []);
    $totalCount = $searchable
        ? array_sum(array_map(fn ($g) => count($g['items'] ?? []), $groups))
        : count($items);
    $allHaystacks = $searchable
        ? collect($groups)->flatMap(function ($group) {
            $context = strip_tags(($group['heading'] ?? '').' '.($group['badge'] ?? ''));

            return collect($group['items'] ?? [])->map(fn ($item) => Illuminate\Support\Str::lower(strip_tags(($item['question'] ?? '').' '.($item['answer'] ?? '').' '.$context)));
        })->all()
        : [];
@endphp

@if($searchable && !empty($groups))
    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6" x-data="{
        query: '',
        active: 'all',
        matches(haystack) {
            const q = this.query.trim().toLowerCase();
            if (q === '') return true;
            const words = q.split(/\s+/).filter(Boolean);
            return words.every(word => haystack.includes(word));
        },
        groupHasMatch(haystacks) { return haystacks.some(h => this.matches(h)); },
        allHaystacks: @js($allHaystacks),
        get hasAnyMatch() { return this.groupHasMatch(this.allHaystacks); },
    }">
        @if($heading)
            <x-section-heading :eyebrow="$eyebrow" align="center">{{ $heading }}</x-section-heading>
        @endif

        <div class="mx-auto mt-8 max-w-xl">
            <div class="relative">
                <x-brand-icon name="ruler" class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-stone" />
                <input
                    type="search"
                    x-model="query"
                    placeholder="Ex : devis gratuit, garantie décennale, zones desservies…"
                    class="w-full border-0 bg-navy-tint/60 py-3 pl-11 pr-3 text-[16px] text-navy placeholder:text-navy/40 focus:bg-white focus:outline focus:outline-2 focus:outline-turquoise-dark"
                    style="min-height:44px"
                    aria-label="Rechercher dans la FAQ"
                >
            </div>
            <div class="mt-3 flex flex-wrap justify-center gap-2 text-xs">
                @foreach(['Devis gratuit', 'Garantie décennale', 'Zéro démarchage', 'Zones desservies'] as $suggestion)
                    <button type="button" @click="query = @js($suggestion)" class="rounded-full border border-stone/30 px-3 py-1 text-navy/70 hover:border-turquoise-dark hover:text-turquoise-dark">
                        {{ $suggestion }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-2">
            <button type="button" @click="active = 'all'" :class="active === 'all' ? 'bg-navy-deep text-white' : 'bg-navy-tint text-navy'" class="px-4 py-2 text-sm font-semibold" style="min-height:44px">
                Toutes les questions ({{ $totalCount }})
            </button>
            @foreach($groups as $index => $group)
                <button type="button" @click="active = {{ $index }}" :class="active === {{ $index }} ? 'bg-navy-deep text-white' : 'bg-navy-tint text-navy'" class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold" style="min-height:44px">
                    @if(!empty($group['icon']))
                        <x-brand-icon :name="$group['icon']" class="h-4 w-4 shrink-0" />
                    @endif
                    {{ $group['heading'] ?? '' }}
                </button>
            @endforeach
        </div>

        <div class="mt-10 space-y-12">
            @foreach($groups as $index => $group)
                @php
                    $groupContext = strip_tags(($group['heading'] ?? '').' '.($group['badge'] ?? ''));
                    $itemHaystacks = collect($group['items'] ?? [])
                        ->map(fn ($item) => Illuminate\Support\Str::lower(strip_tags(($item['question'] ?? '').' '.($item['answer'] ?? '').' '.$groupContext)))
                        ->all();
                @endphp
                <div x-show="(active === 'all' || active === {{ $index }}) && groupHasMatch(@js($itemHaystacks))">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone/20 pb-3">
                        <h3 class="flex items-center gap-2 font-display text-lg font-bold text-navy">
                            @if(!empty($group['icon']))
                                <x-brand-icon :name="$group['icon']" class="h-5 w-5 shrink-0 text-turquoise-dark" />
                            @endif
                            {{ $group['heading'] ?? '' }}
                        </h3>
                        @if(!empty($group['badge']))
                            <span class="text-xs font-semibold uppercase tracking-wide text-turquoise-dark">{{ $group['badge'] }}</span>
                        @endif
                    </div>

                    <div class="mt-4 space-y-3">
                        @foreach($group['items'] ?? [] as $itemIndex => $item)
                            <details class="group bg-navy-tint px-5 py-4 open:bg-navy-tint/70" x-show="matches(@js($itemHaystacks[$itemIndex]))">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-[16px] font-semibold text-navy" style="min-height:44px">
                                    {{ $item['question'] ?? '' }}
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-navy transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </summary>
                                <div class="prose mt-3 max-w-none pr-8 text-[15px] text-navy/80 prose-a:text-turquoise-dark">
                                    {!! $item['answer'] ?? '' !!}
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <p x-show="!hasAnyMatch" class="py-6 text-center text-navy/60">
                Aucune question ne correspond à votre recherche. Essayez un autre mot-clé ou
                <a href="#devis" class="font-semibold text-turquoise-dark underline">posez-nous directement votre question</a>.
            </p>
        </div>

        <div class="mt-14 flex flex-col items-center gap-3 border-t border-stone/20 pt-10 text-center">
            <p class="text-navy/80">Une question spécifique à votre projet ?</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="tel:0972123236" class="btn-primary">
                    <x-brand-icon name="phone" class="h-4 w-4 shrink-0" /> 09 72 12 32 36
                </a>
                <a href="#devis" class="inline-flex items-center justify-center gap-2 rounded-sm bg-navy-tint px-6 font-medium text-navy transition-colors hover:bg-navy-tint/70" style="min-height:44px">
                    Poser ma question par écrit
                </a>
            </div>
        </div>
    </section>
@elseif(!empty($items))
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        @if($heading)
            <x-section-heading :eyebrow="$eyebrow" align="center">{{ $heading }}</x-section-heading>
        @endif

        <div class="mt-10 space-y-3">
            @foreach($items as $item)
                <details class="group bg-navy-tint px-5 py-4 open:bg-navy-tint/70">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-[17px] font-semibold text-navy" style="min-height:44px">
                        {{ $item['question'] ?? '' }}
                        <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0 text-navy transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>
                    <div class="prose mt-3 max-w-none pr-8 text-[15px] text-navy/80 prose-a:text-turquoise-dark">
                        {!! $item['answer'] ?? '' !!}
                    </div>
                </details>
            @endforeach
        </div>
    </section>
@endif
