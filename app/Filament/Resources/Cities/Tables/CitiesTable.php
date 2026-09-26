<?php

namespace App\Filament\Resources\Cities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Ville')->searchable()->sortable(),
                TextColumn::make('postal_code')->label('CP'),
                TextColumn::make('services_count')->counts('services')->label('Services déclinés'),
                IconColumn::make('is_active')->boolean()->label('Active'),
                TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('order');
    }
}
