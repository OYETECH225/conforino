<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\Concerns\SyncsPageBlocks;
use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    use SyncsPageBlocks;

    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->extractBlocks($data);
    }

    protected function afterCreate(): void
    {
        $this->persistBlocks($this->record);
    }
}
