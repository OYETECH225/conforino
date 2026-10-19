<?php

namespace App\Filament\Resources\SanitaryServices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SanitaryServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('')->disk('public'),
                TextColumn::make('title')->label('Prestation')->searchable()->sortable(),
                TextColumn::make('slug')->label('URL')->prefix('/installation-sanitaire/')->color('gray'),
                TextColumn::make('price')
                    ->label('Prix')
                    ->getStateUsing(fn ($record) => $record->priceLabel()),
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
