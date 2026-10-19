<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add(
            'general.footer_tagline',
            "Rénovation intérieure, agencement cuisine & salle de bain et adaptation PMR sur mesure à Argenteuil et dans tout le Val-d'Oise."
        );
        $this->migrator->add('general.footer_artisanat_label', "Artisanat & maîtrise d'œuvre");

        $this->migrator->add('general.guarantee_1_icon', 'shield');
        $this->migrator->add('general.guarantee_1_title', 'Garantie décennale & RC Pro');
        $this->migrator->add('general.guarantee_1_subtitle', 'Groupama Assurances');

        $this->migrator->add('general.guarantee_2_icon', 'handshake');
        $this->migrator->add('general.guarantee_2_title', 'Zéro sous-traitance non déclarée');
        $this->migrator->add('general.guarantee_2_subtitle', 'Artisans internes uniquement');

        $this->migrator->add(
            'general.deontology_text',
            'Engagement déontologique : aucun démarchage téléphonique non sollicité.'
        );

        $this->migrator->add('general.logo_color_path', null);
        $this->migrator->add('general.logo_white_path', null);
    }
};
