<?php

namespace App\Filament\Resources\Realisations;

use App\Filament\Resources\Realisations\Pages\CreateRealisation;
use App\Filament\Resources\Realisations\Pages\EditRealisation;
use App\Filament\Resources\Realisations\Pages\ListRealisations;
use App\Filament\Resources\Realisations\Schemas\RealisationForm;
use App\Filament\Resources\Realisations\Tables\RealisationsTable;
use App\Models\Realisation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RealisationResource extends Resource
{
    protected static ?string $model = Realisation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

    protected static ?string $modelLabel = 'réalisation';

    protected static ?string $pluralModelLabel = 'Réalisations (avant/après)';

    public static function form(Schema $schema): Schema
    {
        return RealisationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RealisationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRealisations::route('/'),
            'create' => CreateRealisation::route('/create'),
            'edit' => EditRealisation::route('/{record}/edit'),
        ];
    }
}
