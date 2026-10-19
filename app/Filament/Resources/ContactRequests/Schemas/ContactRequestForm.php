<?php

namespace App\Filament\Resources\ContactRequests\Schemas;

use App\Models\ContactRequest;
use App\Models\Service;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom')->required(),
                TextInput::make('phone')->label('Téléphone')->tel()->required(),
                TextInput::make('email')->label('Email')->email(),
                TextInput::make('city')->label('Ville'),
                TextInput::make('address')->label('Adresse précise')->columnSpanFull(),
                Select::make('property_type')->label('Type de bien')->options(ContactRequest::PROPERTY_TYPES),
                TextInput::make('surface')->label('Surface (m²)'),
                Select::make('service_id')->label('Prestation demandée')->options(fn () => Service::query()->pluck('title', 'id')),
                Select::make('beneficiary_type')->label('Demande pour')->options(ContactRequest::BENEFICIARY_TYPES),
                TextInput::make('preferred_day')->label('Jour préférentiel'),
                Select::make('preferred_time_slot')->label('Créneau souhaité')->options(ContactRequest::TIME_SLOTS),
                Textarea::make('message')->label('Message')->rows(4)->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('photos')
                    ->label('Photos jointes par le client')
                    ->collection('photos')
                    ->disk('public')
                    ->image()
                    ->multiple()
                    ->disabled()
                    ->columnSpanFull(),
                DateTimePicker::make('consented_at')->label('Consentement donné le')->required(),
                DateTimePicker::make('handled_at')->label('Traitée le'),
            ])->columns(2);
    }
}
