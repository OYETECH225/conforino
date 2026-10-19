<?php

namespace App\Filament\Resources\SanitaryServices\Pages;

use App\Filament\Resources\SanitaryServices\SanitaryServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSanitaryServices extends ListRecords
{
    protected static string $resource = SanitaryServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
