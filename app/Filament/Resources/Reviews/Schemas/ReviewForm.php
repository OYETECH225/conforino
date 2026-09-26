<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Models\City;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('rating')
                    ->label('Note')
                    ->options(['5' => '5 étoiles', '4' => '4 étoiles', '3' => '3 étoiles', '2' => '2 étoiles', '1' => '1 étoile'])
                    ->default('5')
                    ->required(),
                Select::make('source')
                    ->options(['google' => 'Google', 'site' => 'Site (formulaire)'])
                    ->default('site')
                    ->required(),
                Textarea::make('text')
                    ->label('Texte de l\'avis')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('author_name')
                    ->label('Auteur')
                    ->required(),
                Select::make('city_id')
                    ->label('Ville (liste)')
                    ->options(fn () => City::query()->ordered()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('city_label')
                    ->label('Ville (texte libre, si non listée)'),
                DatePicker::make('review_date')
                    ->label('Date de l\'avis'),
                Toggle::make('is_featured')->label('Mettre en avant (page d\'accueil)'),
                Toggle::make('is_published')->label('Publié')->default(true),
                TextInput::make('order')->label('Ordre')->numeric()->default(0),
            ])->columns(2);
    }
}
