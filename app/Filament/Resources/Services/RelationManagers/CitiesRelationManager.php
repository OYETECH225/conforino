<?php

namespace App\Filament\Resources\Services\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Gère les déclinaisons "service + ville" (ex: /services/amenagement-pmr-argenteuil/)
 * sans dupliquer le contenu : chaque ligne du pivot ne stocke qu'un paragraphe local
 * (local_intro) et d'éventuelles surcharges meta, le reste vient du template partagé
 * et du contenu du Service.
 */
class CitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'cities';

    protected static ?string $title = 'Villes desservies (déclinaisons locales)';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('pivot.local_intro')
                ->label('Paragraphe local (anti-duplicate content)')
                ->rows(3)
                ->columnSpanFull(),
            TextInput::make('pivot.meta_title_override')
                ->label('Meta title (surcharge)'),
            TextInput::make('pivot.meta_description_override')
                ->label('Meta description (surcharge)'),
            Toggle::make('pivot.is_published')
                ->label('Publiée')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Ville')
                    ->searchable(),
                TextColumn::make('pivot.local_intro')
                    ->label('Paragraphe local')
                    ->limit(50)
                    ->placeholder('— à rédiger —'),
                IconColumn::make('pivot.is_published')
                    ->label('Publiée')
                    ->boolean(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Textarea::make('local_intro')
                            ->label('Paragraphe local (anti-duplicate content)')
                            ->rows(3),
                        Toggle::make('is_published')->label('Publiée')->default(true),
                    ]),
            ])
            ->recordActions([
                Action::make('editPivot')
                    ->label('Modifier')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        Textarea::make('local_intro')
                            ->label('Paragraphe local (anti-duplicate content)')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('meta_title_override')->label('Meta title (surcharge)'),
                        TextInput::make('meta_description_override')->label('Meta description (surcharge)'),
                        Toggle::make('is_published')->label('Publiée')->default(true),
                    ])
                    ->fillForm(fn ($record): array => $record->pivot->only([
                        'local_intro', 'meta_title_override', 'meta_description_override', 'is_published',
                    ]))
                    ->action(fn ($record, array $data) => $record->pivot->update($data)),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
