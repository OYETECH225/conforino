<?php

namespace App\Filament\Support;

use App\Models\City;
use App\Models\Review;
use App\Support\Icons;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block as BuilderBlock;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

/**
 * Constructeur de blocs partagé entre les Pages et les Services (relation
 * polymorphique HasBlocks sur les deux modèles) : tout le contenu du site,
 * y compris les sections bespoke par prestation, reste éditable depuis
 * l'admin sans dupliquer ce schéma à chaque resource.
 */
class BlocksBuilder
{
    public static function make(): Builder
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
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre (H1)')->required()->columnSpanFull(),
                        Textarea::make('subheading')->label('Sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('proof_line')->label('Ligne de réassurance (sous les boutons)')->columnSpanFull(),
                        FileUpload::make('image')->label('Photo (ou photo "après")')->image()->disk('public')->directory('hero'),
                        FileUpload::make('before_image')->label('Photo "avant" (optionnel, active le curseur avant/après)')->image()->disk('public')->directory('hero'),
                        TextInput::make('cta_label')->label('Texte du bouton principal'),
                        TextInput::make('cta_url')->label('Lien du bouton principal'),
                        TextInput::make('cta2_label')->label('Texte du bouton secondaire'),
                        TextInput::make('cta2_url')->label('Lien du bouton secondaire'),
                        Select::make('strip_icon')->label('Icône du bandeau photo')->options(Icons::options()),
                        TextInput::make('strip_text')->label('Texte du bandeau photo')->columnSpanFull(),
                        TextInput::make('strip_badge')->label('Badge du bandeau photo (ex: NF PMR)'),
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
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Cartes')
                            ->schema([
                                Toggle::make('is_info_card')->label('Carte "info" (icône + chiffre, sans photo)')->live()->columnSpanFull(),
                                Select::make('icon')->label('Icône')->options(Icons::options())->required(),
                                TextInput::make('title')->label('Titre')->required(),
                                Textarea::make('summary')->label('Résumé')->rows(2)->columnSpanFull(),
                                TextInput::make('url')->label('Lien')->required(),
                                TextInput::make('tag')->label('Étiquette sur la photo (ex: PMR & Autonomie)')
                                    ->visible(fn (callable $get) => ! $get('is_info_card')),
                                FileUpload::make('image')->label('Photo')->image()->disk('public')->directory('services-grid')
                                    ->visible(fn (callable $get) => ! $get('is_info_card')),
                                TextInput::make('info_label')->label('Étiquette (carte info)')
                                    ->visible(fn (callable $get) => $get('is_info_card')),
                                TextInput::make('info_value')->label('Valeur affichée (carte info)')
                                    ->visible(fn (callable $get) => $get('is_info_card')),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('testimonials')
                    ->label('Témoignages / Avis clients')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
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
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Toggle::make('searchable')->label('Afficher la barre de recherche et les catégories')->live()->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Questions (mode simple, sans catégories)')
                            ->schema([
                                TextInput::make('question')->required()->columnSpanFull(),
                                RichEditor::make('answer')->required()->columnSpanFull(),
                            ])
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->visible(fn (callable $get) => ! $get('searchable'))
                            ->columnSpanFull(),
                        Repeater::make('groups')
                            ->label('Catégories de questions')
                            ->schema([
                                TextInput::make('heading')->label('Nom de la catégorie')->required()->columnSpanFull(),
                                TextInput::make('badge')->label('Étiquette (ex: Zéro démarchage abusif)')->columnSpanFull(),
                                Select::make('icon')->label('Icône')->options(Icons::options()),
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
                            ])
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['heading'] ?? null)
                            ->visible(fn (callable $get) => (bool) $get('searchable'))
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
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        Toggle::make('wizard')
                            ->label('Assistant de visite technique en 4 étapes (au lieu du formulaire simple)')
                            ->helperText('Prestation, bénéficiaire, coordonnées, créneau souhaité et photos du chantier.')
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('stats')
                    ->label('Chiffres clés')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(4)->columnSpanFull(),
                        Repeater::make('proof_items')
                            ->label('Preuves rapides (avec coche)')
                            ->simple(TextInput::make('text')->required())
                            ->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Chiffres')
                            ->schema([
                                TextInput::make('value')->label('Valeur (ex: 13 ans)')->required(),
                                TextInput::make('label')->label('Légende')->required(),
                                Textarea::make('description')->label('Description courte')->rows(2)->columnSpanFull(),
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
                                FileUpload::make('before_image')->label('Avant')->image()->disk('public')->required(),
                                FileUpload::make('after_image')->label('Après')->image()->disk('public')->required(),
                                TextInput::make('caption')->label('Légende')->columnSpanFull(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('process')
                    ->label('Parcours / étapes numérotées')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Repeater::make('steps')
                            ->label('Étapes')
                            ->schema([
                                Select::make('icon')->label('Icône')->options(Icons::options())->required()->columnSpanFull(),
                                TextInput::make('title')->label('Titre de l\'étape')->required()->columnSpanFull(),
                                Textarea::make('description')->label('Description')->rows(3)->required()->columnSpanFull(),
                                TextInput::make('proof')->label('Preuve rapide (avec coche, optionnel)')->columnSpanFull(),
                            ])
                            ->reorderableWithButtons()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                        Repeater::make('trust_items')
                            ->label('Bandeau de confiance (sous les étapes, optionnel)')
                            ->schema([
                                Select::make('icon')->label('Icône')->options(Icons::options())->required(),
                                TextInput::make('text')->label('Texte')->required()->columnSpanFull(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('gallery_preview')
                    ->label('Aperçu réalisations')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        TextInput::make('count')->label('Nombre de photos à afficher')->numeric()->default(4),
                    ]),

                BuilderBlock::make('feature_grid')
                    ->label('Grille de points forts (icône + titre + texte)')
                    ->icon('heroicon-o-squares-plus')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Points forts')
                            ->schema([
                                Select::make('icon')->label('Icône')->options(Icons::options())->required(),
                                TextInput::make('title')->label('Titre')->required()->columnSpanFull(),
                                Textarea::make('text')->label('Texte')->rows(2)->required()->columnSpanFull(),
                            ])
                            ->reorderableWithButtons()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('pmr_norms')
                    ->label('Normes PMR illustrées')
                    ->icon('heroicon-o-scale')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        Repeater::make('items')
                            ->label('Repères (2 maximum : giration, puis largeur de passage)')
                            ->schema([
                                Select::make('diagram')
                                    ->label('Illustration')
                                    ->options([
                                        'giration' => 'Zone de giration (cercle)',
                                        'passage' => 'Largeur de passage (porte)',
                                    ])
                                    ->required(),
                                TextInput::make('value')->label('Valeur (ex: ⌀ 1,50 m)')->required(),
                                TextInput::make('label')->label('Légende')->required()->columnSpanFull(),
                            ])->columns(2)
                            ->reorderableWithButtons()
                            ->maxItems(2)
                            ->columnSpanFull(),
                    ]),

                BuilderBlock::make('comparison_table')
                    ->label('Tableau comparatif')
                    ->icon('heroicon-o-table-cells')
                    ->schema([
                        TextInput::make('eyebrow')->label('Étiquette au-dessus du titre')->columnSpanFull(),
                        TextInput::make('heading')->label('Titre de la section')->columnSpanFull(),
                        Textarea::make('intro')->label('Texte d\'introduction')->rows(2)->columnSpanFull(),
                        TextInput::make('column_1')->label('Colonne mise en avant (ex: Douche PMR sécurisée)')->required(),
                        TextInput::make('column_2')->label('2ᵉ colonne (ex: Douche classique)')->required(),
                        TextInput::make('column_3')->label('3ᵉ colonne (ex: Baignoire classique)')->required(),
                        Repeater::make('rows')
                            ->label('Lignes du comparatif')
                            ->schema([
                                TextInput::make('label')->label('Critère')->required()->columnSpanFull(),
                                TextInput::make('value_1')->label('Valeur colonne 1')->required(),
                                TextInput::make('value_2')->label('Valeur colonne 2')->required(),
                                TextInput::make('value_3')->label('Valeur colonne 3')->required(),
                            ])->columns(3)
                            ->reorderableWithButtons()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
