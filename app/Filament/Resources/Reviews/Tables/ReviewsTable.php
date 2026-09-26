<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rating')->label('Note')->badge()->formatStateUsing(fn ($state) => str_repeat('★', (int) $state)),
                TextColumn::make('author_name')->label('Auteur')->searchable(),
                TextColumn::make('text')->label('Avis')->limit(60)->searchable(),
                TextColumn::make('city_label')->label('Ville')->getStateUsing(fn ($record) => $record->cityName()),
                TextColumn::make('source')->label('Source')->badge(),
                IconColumn::make('is_featured')->boolean()->label('En avant'),
                IconColumn::make('is_published')->boolean()->label('Publié'),
                TextColumn::make('review_date')->date('d/m/Y')->label('Date'),
            ])
            ->filters([
                SelectFilter::make('source')->label('Source')->options(['google' => 'Google', 'site' => 'Site']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('order');
    }
}
