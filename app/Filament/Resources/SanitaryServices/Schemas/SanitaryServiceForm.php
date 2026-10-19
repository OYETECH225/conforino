<?php

namespace App\Filament\Resources\SanitaryServices\Schemas;

use App\Support\Icons;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SanitaryServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Prestation')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Contenu')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Nom de la prestation')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL : /installation-sanitaire/{slug}')
                                    ->columnSpanFull(),
                                Select::make('icon')
                                    ->label('Icône')
                                    ->options(Icons::options())
                                    ->default('plumbing')
                                    ->required(),
                                FileUpload::make('image')
                                    ->label('Photo (optionnel)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('sanitary-services')
                                    ->helperText('Laisser vide pour afficher un visuel de principe.'),
                                Textarea::make('short_description')
                                    ->label('Description courte')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('price')
                                    ->label('Prix TTC (€)')
                                    ->numeric()
                                    ->step(0.01)
                                    ->required(),
                                Toggle::make('price_is_from')
                                    ->label('Afficher "à partir de" devant le prix'),
                                TextInput::make('price_note')
                                    ->label('Précision sous le prix (ex : conditions TVA réduite)')
                                    ->columnSpanFull(),
                                TextInput::make('duration_label')
                                    ->label('Durée estimée (ex : "Environ 1 heure")'),

                                Repeater::make('included_items')
                                    ->label('Ce qui est inclus')
                                    ->simple(TextInput::make('item')->required())
                                    ->addActionLabel('Ajouter un élément')
                                    ->columnSpanFull(),
                                Repeater::make('excluded_items')
                                    ->label("Ce qui n'est pas inclus")
                                    ->simple(TextInput::make('item')->required())
                                    ->addActionLabel('Ajouter un élément')
                                    ->columnSpanFull(),
                                Repeater::make('client_provides')
                                    ->label('Ce que le client doit fournir')
                                    ->simple(TextInput::make('item')->required())
                                    ->addActionLabel('Ajouter un élément')
                                    ->columnSpanFull(),
                                Textarea::make('extra_note')
                                    ->label('Remarque complémentaire (optionnel)')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta title')
                                    ->maxLength(70)
                                    ->helperText('Si vide : "{nom de la prestation} | CONFOR\'INO Argenteuil"')
                                    ->columnSpanFull(),
                                Textarea::make('meta_description')
                                    ->label('Meta description')
                                    ->maxLength(160)
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Select::make('robots')
                                    ->options([
                                        'index,follow' => 'Indexer (index, follow)',
                                        'noindex,follow' => 'Ne pas indexer mais suivre les liens (noindex, follow)',
                                    ])
                                    ->default('index,follow')
                                    ->required(),
                            ]),

                        Tab::make('Réglages')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Prestation active (visible sur le site)')
                                    ->default(true),
                                TextInput::make('order')
                                    ->label('Ordre d\'affichage')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }
}
