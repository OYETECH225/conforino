<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')->collection('image')->label(''),
                TextColumn::make('title')->label('Prestation')->searchable()->sortable(),
                TextColumn::make('slug')->label('URL')->prefix('/services/')->color('gray'),
                TextColumn::make('cities_count')->counts('cities')->label('Villes déclinées'),
                IconColumn::make('is_active')->boolean()->label('Actif'),
                TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
