<?php

namespace App\Filament\Resources\Realisations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealisationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('after')->collection('after')->label(''),
                TextColumn::make('title')->label('Chantier')->searchable()->sortable(),
                TextColumn::make('service.title')->label('Prestation'),
                TextColumn::make('city.name')->label('Ville'),
                IconColumn::make('is_featured')->boolean()->label('En avant'),
                IconColumn::make('is_published')->boolean()->label('Publiée'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('order');
    }
}
