@props(['before', 'after', 'caption' => null, 'beforeAlt' => 'Avant travaux', 'afterAlt' => 'Après travaux', 'hideHandle' => false])

@php $id = 'slider-'.Illuminate\Support\Str::random(6); @endphp

<figure x-data="{ pos: 50 }" class="select-none">
    <div class="relative aspect-[4/3] overflow-hidden rounded-sm bg-navy-tint sm:aspect-[16/10]">
        @if($after)
            <img src="{{ $after }}" alt="{{ $afterAlt }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
        @endif
        @if($before)
            <div class="absolute inset-0" :style="`clip-path: inset(0 ${100 - pos}% 0 0)`">
                <img src="{{ $before }}" alt="{{ $beforeAlt }}" class="h-full w-full object-cover" loading="lazy">
            </div>
            <div class="pointer-events-none absolute inset-y-0 w-0.5 bg-white shadow-[0_0_0_1px_rgba(30,54,100,0.3)]" :style="`left: calc(${pos}% - 1px)`"></div>
            <span class="pointer-events-none absolute left-3 top-3 rounded-sm bg-navy-deep/85 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                <span class="mr-1 inline-block h-1.5 w-1.5 rounded-full bg-white/70 align-middle"></span>Avant
            </span>
            <span class="pointer-events-none absolute right-3 top-3 rounded-sm bg-turquoise px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                <span class="mr-1 inline-block h-1.5 w-1.5 rounded-full bg-white align-middle"></span>Après
            </span>
        @endif
    </div>

    @if($before && ! $hideHandle)
        <label class="sr-only" for="{{ $id }}">Faire glisser pour comparer avant et après</label>
        <input
            type="range" min="0" max="100" x-model.number="pos"
            id="{{ $id }}"
            class="mt-4 w-full accent-turquoise"
            style="min-height:44px"
        >
    @endif

    @if($caption)
        <figcaption class="mt-2 text-sm text-navy/70">{{ $caption }}</figcaption>
    @endif
</figure>
