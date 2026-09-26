<?php

namespace App\Filament\Resources\Pages\Concerns;

use App\Models\Block;
use App\Models\Page;

/**
 * Le champ Builder "blocks" du formulaire n'est pas une colonne du modèle Page :
 * il est retiré des données avant sauvegarde puis synchronisé manuellement vers
 * la table `blocks` (une ligne par bloc, avec type/data/order), ce qui permet
 * de garder un historique propre et des requêtes simples côté front.
 */
trait SyncsPageBlocks
{
    protected ?array $pendingBlocks = null;

    protected function extractBlocks(array $data): array
    {
        $this->pendingBlocks = $data['blocks'] ?? [];
        unset($data['blocks']);

        return $data;
    }

    protected function persistBlocks(Page $page): void
    {
        $page->blocks()->delete();

        foreach ($this->pendingBlocks ?? [] as $index => $item) {
            $page->blocks()->create([
                'type' => $item['type'],
                'data' => $item['data'] ?? [],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
