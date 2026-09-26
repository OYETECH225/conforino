<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\City;
use App\Models\Review;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block as BuilderBlock;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Utilisé dans l\'URL. Ex : "a-propos" -> /a-propos')
                                    ->columnSpanFull(),
                                TextInput::make('breadcrumb_title')
                                    ->helperText('Libellé affiché dans le fil d\'Ariane si différent du titre.')
                                    ->columnSpanFull(),

                                static::blocksBuilder(),
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
                            ])->columns(2),
                    ]),
            ]);
    }

    protected static function blocksBuilder(): Builder
    {
        $cityOptions = fn () => City::query()->active()->ordered()->pluck('name', 'id');
        $reviewOptions = fn () => Review::query()->published()->pluck('author_name', 'id');

        return Builder::make('blocks')
            ->label('Blocs de contenu')
            ->addActionLabel('Ajouter un bloc')
            ->collapsible()
            ->collapsed()
            ->cloneable()
            ->reorderableWithButtons()
            ->columnSpanFull()
            ->blocks([
                BuilderBlock::make('hero')
                    ->label('Hero')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        TextInput::make('heading')->label('Titre (H1)')->required()->columnSpanFull(),
                        Textarea::make('subheading')->label('Sous-titre')->rows(2)->columnSpanFull(),
                        FileUpload::make('image')->label('Photo avant/après')->image()->directory('hero'),
                        TextInput::make('cta_label')->label('Texte du bouton'),
                        TextInput::make('cta_url')->label('Lien du bouton'),
                    ])->columns(2),

                BuilderBlock::make('rich_text')
                    ->label('Texte riche')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        RichEditor::make('content')->label('Contenu')->columnSpanFull(),
                    ]),

                BuilderBlock::make('services_grid')
                    ->label('Grille de services')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Cartes')
                            ->schema([
                                Select::make('icon')->label('Icône')->options(\App\Support\Icons::options())->required(),
                                TextInput::make('title')->label('Titre')->required(),
                                Textarea::make('summary')->label('Résumé')->rows(2)->columnSpanFull(),
                                TextInput::make('url')->label('Lien')->required(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('testimonials')
                    ->label('Témoignages / Avis clients')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Select::make('review_ids')
                            ->label('Avis à afficher')
                            ->multiple()
                            ->options($reviewOptions)
                            ->searchable()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('faq')
                    ->label('FAQ')
                    ->icon('heroicon-o-question-mark-circle')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Questions')
                            ->schema([
                                TextInput::make('question')->required()->columnSpanFull(),
                                RichEditor::make('answer')->required()->columnSpanFull(),
                            ])
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('service_areas')
                    ->label('Zones desservies')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        Select::make('city_ids')
                            ->label('Villes à afficher')
                            ->multiple()
                            ->options($cityOptions)
                            ->searchable()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('contact_form')
                    ->label('Formulaire de contact / devis')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                    ]),

                BuilderBlock::make('stats')
                    ->label('Chiffres clés')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Chiffres')
                            ->schema([
                                TextInput::make('value')->label('Valeur (ex: 13 ans)')->required(),
                                TextInput::make('label')->label('Légende')->required(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('before_after')
                    ->label('Avant / Après')
                    ->icon('heroicon-o-arrows-right-left')
                    ->schema([
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Paires avant / après')
                            ->schema([
                                FileUpload::make('before_image')->label('Avant')->image()->required(),
                                FileUpload::make('after_image')->label('Après')->image()->required(),
                                TextInput::make('caption')->label('Légende')->columnSpanFull(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
