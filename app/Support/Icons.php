<?php

namespace App\Support;

/**
 * Registre des icônes SVG maison (trait fin turquoise) disponibles dans
 * resources/views/components/icons/*.blade.php, utilisées à la fois dans
 * l'admin Filament (sélecteurs) et dans les vues publiques (<x-icon />).
 */
class Icons
{
    public static function options(): array
    {
        return [
            'kitchen' => 'Cuisine',
            'bathroom' => 'Salle de bain',
            'pmr' => 'Accessibilité PMR',
            'renovation' => 'Rénovation intérieure',
            'plumbing' => 'Plomberie',
            'electricity' => 'Électricité',
            'painting' => 'Peinture & finitions',
            'partition' => 'Cloisons',
            'ruler' => 'Étude / cotes',
            'shield' => 'Garantie décennale',
            'clock' => 'Délais / rapidité',
            'phone' => 'Téléphone',
            'pin' => 'Localisation',
            'star' => 'Avis / note',
            'check' => 'Validation',
            'quote' => 'Citation',
            'handshake' => 'Accompagnement',
        ];
    }

    public static function keys(): array
    {
        return array_keys(static::options());
    }
}
