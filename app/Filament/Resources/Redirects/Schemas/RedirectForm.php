<?php

namespace App\Filament\Resources\Redirects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('from_path')
                    ->label('Ancienne URL (chemin)')
                    ->required()
                    ->placeholder('/services/entreprise-cuisine-95/')
                    ->helperText('Chemin relatif de l\'ancien site conforino.fr, avec le / initial.')
                    ->columnSpanFull(),
                TextInput::make('to_path')
                    ->label('Nouvelle URL de destination')
                    ->required()
                    ->different('from_path')
                    ->placeholder('/services/agencement-cuisine/')
                    ->helperText('Doit être différente de l\'ancienne URL (sans quoi la redirection est inutile).')
                    ->columnSpanFull(),
                Select::make('status_code')
                    ->label('Type de redirection')
                    ->options(['301' => '301 - Permanente', '302' => '302 - Temporaire'])
                    ->default('301')
                    ->required(),
                Toggle::make('is_active')->label('Active')->default(true),
            ])->columns(2);
    }
}
