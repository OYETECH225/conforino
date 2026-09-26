<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\Concerns\SyncsPageBlocks;
use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use SyncsPageBlocks;

    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['blocks'] = $this->record->blocks()
            ->orderBy('order')
            ->get()
            ->map(fn ($block) => ['type' => $block->type, 'data' => $block->data])
            ->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->extractBlocks($data);
    }

    protected function afterSave(): void
    {
        $this->persistBlocks($this->record);
    }
}
