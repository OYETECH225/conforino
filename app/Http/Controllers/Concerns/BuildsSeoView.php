<?php

namespace App\Http\Controllers\Concerns;

use App\Services\Seo\SchemaBuilder;

trait BuildsSeoView
{
    /**
     * Assemble les variables partagées par le layout public (SEO + JSON-LD +
     * fil d'Ariane) à partir d'un jeu de schémas et d'un fil d'Ariane commun.
     *
     * @param  array{title:string,description:?string,canonical:string,robots:string,ogImage:?string}  $seo
     * @param  array<int, array{name:string,url:string}>  $breadcrumbs
     * @param  array<int, array>  $extraSchemas  Schémas additionnels (Service, FAQPage...)
     */
    protected function seoViewData(array $seo, array $breadcrumbs, array $extraSchemas = []): array
    {
        $builder = app(SchemaBuilder::class);

        $schemas = [$builder->localBusiness()];

        if (count($breadcrumbs) > 1) {
            $schemas[] = $builder->breadcrumbs($breadcrumbs);
        }

        foreach ($extraSchemas as $schema) {
            $schemas[] = $schema;
        }

        return [
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $builder->combine($schemas),
        ];
    }
}
