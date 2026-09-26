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

    public static function group(): string
    {
        return 'general';
    }
}
