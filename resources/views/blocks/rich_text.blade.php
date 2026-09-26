@php $content = $block->get('content'); @endphp

@if($content)
    <section class="mx-auto max-w-3xl px-4 py-14 sm:px-6">
        <div class="prose max-w-none prose-headings:font-display prose-headings:text-navy prose-a:text-turquoise-dark prose-strong:text-navy">
            {!! $content !!}
        </div>
    </section>
@endif
