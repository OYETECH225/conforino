@if($page->isLandingTemplate())
    <x-landing-layout :seo="$seo" :json-ld="$jsonLd">
        <x-render-blocks :blocks="$page->activeBlocks" />
    </x-landing-layout>
@else
    <x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">
        <x-render-blocks :blocks="$page->activeBlocks" />
    </x-layout>
@endif
