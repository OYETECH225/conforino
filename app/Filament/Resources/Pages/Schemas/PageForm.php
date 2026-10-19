<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\BlocksBuilder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Page')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Contenu')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre de la page')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Utilisé dans l\'URL. Ex : "a-propos" -> /a-propos')
                                    ->columnSpanFull(),
                                TextInput::make('breadcrumb_title')
                                    ->label('Titre dans le fil d\'Ariane')
                                    ->helperText('Libellé affiché dans le fil d\'Ariane si différent du titre.')
                                    ->columnSpanFull(),

                                BlocksBuilder::make(),
                            ]),

                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta title')
                                    ->maxLength(70)
                                    ->helperText('Si vide : "{titre de la page} | CONFOR\'INO"')
                                    ->columnSpanFull(),
                                Textarea::make('meta_description')
                                    ->label('Meta description')
                                    ->maxLength(160)
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('canonical_url')
                                    ->label('URL canonique (optionnel)')
                                    ->url()
                                    ->helperText('Si vide, l\'URL de la page elle-même est utilisée.')
                                    ->columnSpanFull(),
                                Select::make('robots')
                                    ->options([
                                        'index,follow' => 'Indexer (index, follow)',
                                        'noindex,follow' => 'Ne pas indexer mais suivre les liens (noindex, follow)',
                                        'noindex,nofollow' => 'Ne pas indexer, ne pas suivre (noindex, nofollow)',
                                    ])
                                    ->default('index,follow')
                                    ->required(),
                                Select::make('schema_type')
                                    ->label('Données structurées (Schema.org)')
                                    ->options([
                                        'WebPage' => 'Page générique (WebPage)',
                                        'LocalBusiness' => 'Établissement local (LocalBusiness)',
                                        'Service' => 'Service',
                                        'FAQPage' => 'Page de FAQ (FAQPage)',
                                        'Article' => 'Article',
                                    ])
                                    ->default('WebPage')
                                    ->required(),
                                FileUpload::make('og_image')
                                    ->label('Image de partage (Open Graph)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('og-images')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tab::make('Réglages')
                            ->schema([
                                Select::make('status')
                                    ->options(['draft' => 'Brouillon', 'published' => 'Publié'])
                                    ->default('draft')
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('Date de publication'),
                                Toggle::make('show_breadcrumb')
                                    ->label('Afficher le fil d\'Ariane')
                                    ->default(true),
                                Select::make('template')
                                    ->label('Gabarit de page')
                                    ->options([
                                        'default' => 'Standard (menu et pied de page complets)',
                                        'landing' => "Landing page (Ads) — sans menu, formulaire de devis mis en avant",
                                    ])
                                    ->default('default')
                                    ->required()
                                    ->helperText("Le gabarit « Landing page » retire le menu et les liens de navigation pour concentrer le visiteur sur le formulaire de devis : à utiliser pour les pages pointées par une campagne Google Ads. Pensez à passer le SEO en « noindex » si la page ne doit pas apparaître dans Google.")
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ]),
            ]);
    }
}
