<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Réglages du site';

    protected static ?string $title = 'Réglages généraux';

    protected static string $settings = GeneralSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Réglages')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Coordonnées (NAP)')
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Raison sociale')
                                    ->required(),
                                TextInput::make('address_street')
                                    ->label('Adresse')
                                    ->required(),
                                TextInput::make('address_postal_code')
                                    ->label('Code postal')
                                    ->required(),
                                TextInput::make('address_city')
                                    ->label('Ville')
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Téléphone affiché')
                                    ->tel()
                                    ->required(),
                                TextInput::make('call_tracking_phone')
                                    ->label('Numéro de call tracking (remplace le téléphone si renseigné)')
                                    ->tel()
                                    ->helperText('Laisser vide pour utiliser directement le téléphone principal.'),
                                TextInput::make('email')
                                    ->label('Email de contact')
                                    ->email()
                                    ->required(),
                                TextInput::make('opening_hours')
                                    ->label('Horaires')
                                    ->required(),
                            ])->columns(2),

                        Tab::make('Réseaux sociaux')
                            ->schema([
                                TextInput::make('facebook_url')->label('Facebook')->url(),
                                TextInput::make('instagram_url')->label('Instagram')->url(),
                                TextInput::make('linkedin_url')->label('LinkedIn')->url(),
                                TextInput::make('google_business_url')->label('Fiche Google Business Profile')->url(),
                            ])->columns(2),

                        Tab::make('RGPD & confidentialité')
                            ->schema([
                                Textarea::make('cookie_banner_text')
                                    ->label('Texte du bandeau cookies')
                                    ->required()
                                    ->rows(3),
                                Textarea::make('privacy_policy_summary')
                                    ->label('Résumé affiché sur le formulaire de contact')
                                    ->required()
                                    ->rows(3),
                            ]),

                        Tab::make('SEO technique')
                            ->schema([
                                Textarea::make('robots_txt')
                                    ->label('Contenu de robots.txt')
                                    ->required()
                                    ->rows(8)
                                    ->helperText('Servi directement sur /robots.txt'),
                                TextInput::make('ga4_id')
                                    ->label('ID Google Analytics 4 (G-XXXXXXX)'),
                                TextInput::make('gtm_id')
                                    ->label('ID Google Tag Manager (GTM-XXXXXXX)'),
                            ]),
                    ]),
            ]);
    }
}
