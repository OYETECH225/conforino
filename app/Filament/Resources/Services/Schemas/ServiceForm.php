<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Support\Icons;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Service')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Contenu')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre de la prestation')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL : /services/{slug}/')
                                    ->columnSpanFull(),
                                Select::make('icon')
                                    ->label('Icône')
                                    ->options(Icons::options())
                                    ->required()
                                    ->native(false),
                                SpatieMediaLibraryFileUpload::make('image')
                                    ->collection('image')
                                    ->image()
                                    ->label('Photo principale'),
                                Textarea::make('short_description')
                                    ->label('Description courte (cartes, listing)')
                                    ->rows(2)
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('long_description')
                                    ->label('Description longue (page service)')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->helperText('Si vide : "{titre} | CONFOR\'INO Argenteuil"')
                                    ->columnSpanFull(),
                                Textarea::make('meta_description')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('canonical_url')
                                    ->url()
                                    ->columnSpanFull(),
                                Select::make('robots')
                                    ->options([
                                        'index,follow' => 'Indexer (index, follow)',
                                        'noindex,follow' => 'Ne pas indexer (noindex, follow)',
                                    ])
                                    ->default('index,follow')
                                    ->required(),
                            ]),

                        Tab::make('Réglages')
                            ->schema([
                                Toggle::make('is_active')->label('Actif / visible sur le site')->default(true),
                                TextInput::make('order')->label('Ordre d\'affichage')->numeric()->default(0),
                            ])->columns(2),
                    ]),
            ]);
    }
}
