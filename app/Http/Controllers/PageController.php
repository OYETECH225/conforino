<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoView;
use App\Models\Block;
use App\Models\Page;
use App\Services\Seo\SchemaBuilder;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    use BuildsSeoView;

    public function home()
    {
        return $this->show('accueil');
    }

    public function show(string $slug): Response
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->published()
            ->with('activeBlocks')
            ->firstOrFail();

        $isHome = $slug === 'accueil';

        $breadcrumbs = $isHome
            ? [['name' => 'Accueil', 'url' => url('/')]]
            : [
                ['name' => 'Accueil', 'url' => url('/')],
                ['name' => $page->breadcrumb_title ?: $page->title, 'url' => $page->canonicalUrl()],
            ];

        $extraSchemas = [];
        $faqBlock = $page->activeBlocks->firstWhere('type', Block::TYPE_FAQ);

        if ($faqBlock) {
            $faqItems = $faqBlock->get('items') ?: collect($faqBlock->get('groups', []))
                ->flatMap(fn (array $group) => $group['items'] ?? [])
                ->all();

            if (! empty($faqItems)) {
                $extraSchemas[] = app(SchemaBuilder::class)->faqPage($faqItems);
            }
        }

        return response()->view('pages.show', array_merge([
            'page' => $page,
            'showBreadcrumb' => $page->show_breadcrumb && ! $isHome,
        ], $this->seoViewData([
            'title' => $page->metaTitle(),
            'description' => $page->metaDescription(),
            'canonical' => $page->canonicalUrl(),
            'robots' => $page->robots,
            'ogImage' => $page->ogImageUrl(),
        ], $breadcrumbs, $extraSchemas)));
    }
}
