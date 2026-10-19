<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Concerns\SyncsBlocks;
use App\Filament\Resources\Services\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    use SyncsBlocks;

    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->extractBlocks($data);
    }

    protected function afterCreate(): void
    {
        $this->persistBlocks($this->record);
    }
}
