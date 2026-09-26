<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.company_name', "CONFOR'INO");
        $this->migrator->add('general.address_street', '8 rue Yves Farges');
        $this->migrator->add('general.address_postal_code', '95100');
        $this->migrator->add('general.address_city', 'Argenteuil');
        $this->migrator->add('general.phone', '09 72 12 32 36');
        $this->migrator->add('general.email', 'contact@conforino.fr');
        $this->migrator->add('general.call_tracking_phone', null);
        $this->migrator->add('general.opening_hours', 'Lundi - Vendredi : 9h - 18h');

        $this->migrator->add('general.facebook_url', null);
        $this->migrator->add('general.instagram_url', null);
        $this->migrator->add('general.linkedin_url', null);
        $this->migrator->add('general.google_business_url', null);

        $this->migrator->add(
            'general.cookie_banner_text',
            "Nous utilisons des cookies pour assurer le bon fonctionnement du site, améliorer votre expérience et, avec votre accord, mesurer l'audience du site."
        );

        $this->migrator->add(
            'general.privacy_policy_summary',
            "CONFOR'INO utilise vos données pour traiter votre demande, vous rappeler et préparer, le cas échéant, un devis. Consultez notre politique de confidentialité pour connaître les destinataires, les durées de conservation et vos droits."
        );

        $this->migrator->add('general.robots_txt', <<<'TXT'
        User-agent: *
        Allow: /

        Sitemap: /sitemap.xml
        TXT);

        $this->migrator->add('general.ga4_id', null);
        $this->migrator->add('general.gtm_id', null);
    }
};
