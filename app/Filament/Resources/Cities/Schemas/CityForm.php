<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom de la ville')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('postal_code')
                    ->label('Code postal'),
                Textarea::make('description_short')
                    ->label('Description locale courte')
                    ->helperText('Utilisée sur la page "Zones d\'intervention" pour différencier chaque ville et éviter le duplicate content.')
                    ->rows(2)
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Active / visible sur le site')->default(true),
                TextInput::make('order')->label('Ordre d\'affichage')->numeric()->default(0),
            ])->columns(2);
    }
}
