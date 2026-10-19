@php
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $cityIds = $block->get('city_ids', []);
    $cities = \App\Models\City::query()->active()->whereIn('id', $cityIds)->ordered()->get();
@endphp

@if($cities->isNotEmpty())
    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            @if($heading)
                <h2 class="cote font-display text-2xl font-semibold text-navy sm:text-3xl">{{ $heading }}</h2>
            @endif
            @if($intro)
                <p class="mt-4 max-w-2xl text-[15px] text-navy/75">{{ $intro }}</p>
            @endif

            <ul class="reveal mt-8 flex flex-wrap gap-3">
                @foreach($cities as $city)
                    <li>
                        <a href="{{ route('cities.index') }}#{{ $city->slug }}" class="inline-flex items-center gap-2 rounded-sm border border-stone/30 bg-white px-4 py-2 text-[15px] text-navy hover:border-turquoise" style="min-height:44px">
                            <x-brand-icon name="pin" class="h-4 w-4 text-turquoise-dark" />
                            {{ $city->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
