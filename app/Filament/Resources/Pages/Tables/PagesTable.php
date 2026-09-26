<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->prefix('/')
                    ->color('gray'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'published' ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state): string => $state === 'published' ? 'Publié' : 'Brouillon'),
                TextColumn::make('schema_type')
                    ->label('Schema.org')
                    ->badge(),
                TextColumn::make('robots')
                    ->label('Indexation')
                    ->badge()
                    ->color(fn (string $state): string => str_starts_with($state, 'index') ? 'success' : 'danger'),
                TextColumn::make('updated_at')
                    ->label('Modifiée')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(['draft' => 'Brouillon', 'published' => 'Publié']),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
