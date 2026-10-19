<?php

namespace App\Filament\Resources\ContactRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Models\ContactRequest;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                TextColumn::make('service.title')->label('Prestation')->default('—'),
                TextColumn::make('property_type')->label('Type de bien')->formatStateUsing(fn (?string $state) => $state ? ContactRequest::PROPERTY_TYPES[$state] ?? $state : '—'),
                TextColumn::make('surface')->label('Surface')->formatStateUsing(fn (?string $state) => $state ? $state.' m²' : '—'),
                TextColumn::make('preferred_day')->label('Créneau souhaité')->formatStateUsing(fn ($record) => trim(($record->preferred_day ?? '').' '.($record->preferred_time_slot ? '('.(ContactRequest::TIME_SLOTS[$record->preferred_time_slot] ?? $record->preferred_time_slot).')' : '')) ?: '—'),
                TextColumn::make('media_count')->label('Photos')->counts('media')->badge(),
                TextColumn::make('message')->label('Message')->limit(40),
                IconColumn::make('handled_at')->label('Traitée')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('handled_at')
                    ->label('Traitée')
                    ->nullable(),
                SelectFilter::make('property_type')
                    ->label('Type de bien')
                    ->options(ContactRequest::PROPERTY_TYPES),
                SelectFilter::make('service_id')
                    ->label('Prestation')
                    ->relationship('service', 'title'),
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
