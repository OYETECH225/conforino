<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // NAP (Name, Address, Phone) — utilisé pour le schéma LocalBusiness sur toutes les pages
    public string $company_name;

    public string $address_street;

    public string $address_postal_code;

    public string $address_city;

    public string $phone;

    public string $email;

    public ?string $call_tracking_phone;

    public string $opening_hours;

    // Réseaux sociaux
    public ?string $facebook_url;

    public ?string $instagram_url;

    public ?string $linkedin_url;

    public ?string $google_business_url;

    // RGPD / cookies
    public string $cookie_banner_text;

    public string $privacy_policy_summary;

    // Fichiers techniques
    public string $robots_txt;

    // Tracking
    public ?string $ga4_id;

    public ?string $gtm_id;

    // Pied de page
    public string $footer_tagline;

    public string $footer_artisanat_label;

    public string $guarantee_1_icon;

    public string $guarantee_1_title;

    public string $guarantee_1_subtitle;

    public string $guarantee_2_icon;

    public string $guarantee_2_title;

    public string $guarantee_2_subtitle;

    public string $deontology_text;

    // Logos (chemins sur le disque public, remplace les fichiers statiques)
    public ?string $logo_color_path;

    public ?string $logo_white_path;

    public static function group(): string
    {
        return 'general';
    }
}
