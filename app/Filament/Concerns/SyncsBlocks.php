<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Le champ Builder "blocks" du formulaire n'est pas une colonne du modèle :
 * il est retiré des données avant sauvegarde puis synchronisé manuellement vers
 * la table `blocks` (une ligne par bloc, avec type/data/order), ce qui permet
 * de garder un historique propre et des requêtes simples côté front. Partagé
 * entre Pages et Services (relation polymorphique HasBlocks sur les deux).
 */
trait SyncsBlocks
{
    protected ?array $pendingBlocks = null;

    protected function extractBlocks(array $data): array
    {
        $this->pendingBlocks = $data['blocks'] ?? [];
        unset($data['blocks']);

        return $data;
    }

    protected function persistBlocks(Model $record): void
    {
        $record->blocks()->delete();

        foreach ($this->pendingBlocks ?? [] as $index => $item) {
            $record->blocks()->create([
                'type' => $item['type'],
                'data' => $item['data'] ?? [],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
