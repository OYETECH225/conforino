<?php

namespace App\Filament\Resources\ContactRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
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
                Textarea::make('message')->label('Message')->rows(4)->columnSpanFull(),
                DateTimePicker::make('consented_at')->label('Consentement donné le')->required(),
                DateTimePicker::make('handled_at')->label('Traitée le'),
            ])->columns(2);
    }
}
