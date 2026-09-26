<?php

namespace App\Filament\Resources\Realisations\Schemas;

use App\Models\City;
use App\Models\Service;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RealisationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titre du chantier')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                    ->columnSpanFull(),
                TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('before')
                    ->collection('before')
                    ->image()
                    ->required()
                    ->label('Photo "avant"'),
                SpatieMediaLibraryFileUpload::make('after')
                    ->collection('after')
                    ->image()
                    ->required()
                    ->label('Photo "après"'),

                Select::make('service_id')
                    ->label('Prestation liée')
                    ->options(fn () => Service::query()->ordered()->pluck('title', 'id'))
                    ->searchable(),
                Select::make('city_id')
                    ->label('Ville')
                    ->options(fn () => City::query()->ordered()->pluck('name', 'id'))
                    ->searchable(),

                TextInput::make('surface')->label('Surface (ex : 6 m²)'),
                TextInput::make('duration')->label('Durée des travaux (ex : 2 semaines)'),

                Textarea::make('description')
                    ->label('Description du projet')
                    ->rows(4)
                    ->columnSpanFull(),

                Toggle::make('is_featured')->label('Mettre en avant (page d\'accueil)'),
                Toggle::make('is_published')->label('Publiée')->default(true),
                TextInput::make('order')->label('Ordre')->numeric()->default(0),
            ])->columns(2);
    }
}
