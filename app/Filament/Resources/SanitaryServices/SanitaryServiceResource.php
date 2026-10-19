<?php

namespace App\Filament\Resources\SanitaryServices;

use App\Filament\Resources\SanitaryServices\Pages\CreateSanitaryService;
use App\Filament\Resources\SanitaryServices\Pages\EditSanitaryService;
use App\Filament\Resources\SanitaryServices\Pages\ListSanitaryServices;
use App\Filament\Resources\SanitaryServices\Schemas\SanitaryServiceForm;
use App\Filament\Resources\SanitaryServices\Tables\SanitaryServicesTable;
use App\Models\SanitaryService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SanitaryServiceResource extends Resource
{
    protected static ?string $model = SanitaryService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

    protected static ?string $modelLabel = 'prestation sanitaire';

    protected static ?string $pluralModelLabel = 'Plomberie & installation sanitaire';

    protected static ?string $navigationLabel = 'Plomberie & inst. sanitaire';

    public static function form(Schema $schema): Schema
    {
        return SanitaryServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SanitaryServicesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSanitaryServices::route('/'),
            'create' => CreateSanitaryService::route('/create'),
            'edit' => EditSanitaryService::route('/{record}/edit'),
        ];
    }
}
