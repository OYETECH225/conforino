<?php

namespace App\Filament\Resources\SanitaryServices\Pages;

use App\Filament\Resources\SanitaryServices\SanitaryServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSanitaryService extends EditRecord
{
    protected static string $resource = SanitaryServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
