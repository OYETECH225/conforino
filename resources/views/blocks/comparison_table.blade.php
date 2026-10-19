@php
    $eyebrow = $block->get('eyebrow');
    $heading = $block->get('heading');
    $intro = $block->get('intro');
    $column1 = $block->get('column_1');
    $column2 = $block->get('column_2');
    $column3 = $block->get('column_3');
    $rows = $block->get('rows', []);
@endphp

@if(!empty($rows))
    <section class="bg-navy-tint py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            @if($heading)
                <x-section-heading :eyebrow="$eyebrow">{{ $heading }}</x-section-heading>
            @endif
            @if($intro)
                <p class="mt-4 max-w-2xl text-[15px] text-navy/75">{{ $intro }}</p>
            @endif

            <div class="mt-10 overflow-x-auto">
                <table class="w-full min-w-[560px] border-collapse text-left text-[15px]">
                    <thead>
                        <tr>
                            <th class="border-b border-stone/20 py-3 pr-4 font-display text-sm font-semibold uppercase tracking-wide text-navy/60"></th>
                            <th class="border-b-2 border-turquoise-dark bg-turquoise-tint px-4 py-3 font-display text-base font-bold text-navy">{{ $column1 }}</th>
                            <th class="border-b border-stone/20 px-4 py-3 font-display text-base font-semibold text-navy/70">{{ $column2 }}</th>
                            <th class="border-b border-stone/20 px-4 py-3 font-display text-base font-semibold text-navy/70">{{ $column3 }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td class="border-b border-stone/15 py-3 pr-4 font-medium text-navy/70">{{ $row['label'] ?? '' }}</td>
                                <td class="border-b border-stone/15 bg-turquoise-tint/40 px-4 py-3 font-medium text-navy">{{ $row['value_1'] ?? '' }}</td>
                                <td class="border-b border-stone/15 px-4 py-3 text-navy/70">{{ $row['value_2'] ?? '' }}</td>
                                <td class="border-b border-stone/15 px-4 py-3 text-navy/70">{{ $row['value_3'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endif
