<?php

namespace App\Filament\Resources\ContactRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Reçue le')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('name')->label('Nom')->searchable(),
                TextColumn::make('phone')->label('Téléphone'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('city')->label('Ville'),
                TextColumn::make('message')->label('Message')->limit(40),
                IconColumn::make('handled_at')->label('Traitée')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('handled_at')
                    ->label('Traitée')
                    ->nullable(),
            ])
            ->recordActions([
                Action::make('markHandled')
                    ->label('Marquer traitée')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => ! $record->handled_at)
                    ->action(fn ($record) => $record->update(['handled_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
