<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

/**
 * Villes desservies reprises de la page /services/amenagement-pmr-argenteuil/
 * et des autres pages services de l'ancien site conforino.fr.
 */
class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Argenteuil', 'postal_code' => '95100', 'description_short' => "Argenteuil est le siège de CONFOR'INO : nos équipes y interviennent au quotidien pour des chantiers de rénovation, d'agencement et d'adaptation PMR, avec un temps de déplacement minimal."],
            ['name' => 'Sannois', 'postal_code' => '95110', 'description_short' => 'À Sannois, nous intervenons régulièrement sur des pavillons individuels pour des projets de rénovation intérieure et des adaptations PMR de salle de bain.'],
            ['name' => 'Ermont', 'postal_code' => '95120', 'description_short' => "Ermont fait partie de nos secteurs d'intervention réguliers, avec une bonne connaissance des copropriétés et maisons de ville du secteur."],
            ['name' => 'Franconville', 'postal_code' => '95130', 'description_short' => 'À Franconville, nos équipes réalisent aussi bien des rénovations complètes que des interventions ciblées (salle de bain, cuisine, accessibilité).'],
            ['name' => 'Eaubonne', 'postal_code' => '95600', 'description_short' => "Eaubonne fait partie du Val-d'Oise couvert par CONFOR'INO pour les travaux de rénovation intérieure et d'agencement."],
            ['name' => 'Enghien-les-Bains', 'postal_code' => '95880', 'description_short' => 'Enghien-les-Bains, avec son bâti souvent ancien, nécessite une attention particulière lors des travaux de rénovation et de mise aux normes.'],
            ['name' => 'Montmorency', 'postal_code' => '95160', 'description_short' => "Nous intervenons à Montmorency pour des projets d'agencement cuisine et salle de bain, ainsi que des adaptations PMR."],
            ['name' => 'Saint-Gratien', 'postal_code' => '95210', 'description_short' => "Saint-Gratien est desservie par CONFOR'INO pour l'ensemble de nos prestations de rénovation et d'accessibilité."],
            ['name' => 'Taverny', 'postal_code' => '95150', 'description_short' => 'À Taverny, nous accompagnons particuliers et copropriétés sur des chantiers de rénovation intérieure et des adaptations PMR.'],
            ['name' => 'Cergy', 'postal_code' => '95000', 'description_short' => "Cergy fait partie des villes les plus éloignées de notre secteur d'intervention élargi dans le Val-d'Oise."],
            ['name' => 'Garges-lès-Gonesse', 'postal_code' => '95140', 'description_short' => 'Nos équipes interviennent à Garges-lès-Gonesse pour des travaux de rénovation intérieure et des aménagements PMR.'],
            ['name' => "Saint-Ouen-l'Aumône", 'postal_code' => '95310', 'description_short' => "Saint-Ouen-l'Aumône fait partie de notre zone de déplacement pour les prestations de rénovation et d'agencement."],
        ];

        foreach ($cities as $index => $city) {
            City::query()->updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($city['name'])],
                [
                    'name' => $city['name'],
                    'postal_code' => $city['postal_code'],
                    'description_short' => $city['description_short'],
                    'is_active' => true,
                    'order' => $index,
                ]
            );
        }
    }
}
