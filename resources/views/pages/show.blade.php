<x-layout :seo="$seo" :breadcrumbs="$breadcrumbs" :json-ld="$jsonLd" :show-breadcrumb="$showBreadcrumb">
    <x-render-blocks :blocks="$page->activeBlocks" />
</x-layout>
