@props(['blocks'])

@foreach($blocks as $block)
    @includeFirst(["blocks.{$block->type}", 'blocks.missing'], ['block' => $block])
@endforeach
