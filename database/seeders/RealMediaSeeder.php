<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Realisation;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Attache les vraies photos de chantiers CONFOR'INO (récupérées depuis
 * conforino.fr, stockées dans database/seeders/assets/) aux services et à
 * quelques réalisations. Aucune paire avant/après n'est inventée : ces
 * photos sont des résultats finis, affichés en simple visuel — jamais
 * présentées comme une transformation documentée qui n'existe pas.
 */
class RealMediaSeeder extends Seeder
{
    protected string $assetsPath;

    public function run(): void
    {
        $this->assetsPath = database_path('seeders/assets');

        $this->attachServiceImages();
        $this->seedRealisations();
    }

    protected function attachServiceImages(): void
    {
        $map = [
            'agencement-cuisine' => ['image' => 'cuisine-1.jpg', 'gallery' => ['cuisine-2.jpg']],
            'agencement-salle-de-bain' => ['image' => 'salle-de-bain-1.jpg', 'gallery' => ['salle-de-bain-2.jpg']],
            'amenagement-pmr' => ['image' => 'pmr-1.jpg', 'gallery' => ['pmr-2.jpg', 'pmr-podotactile.png']],
            'renovation-interieure' => ['image' => 'renovation-1.jpeg', 'gallery' => ['renovation-peinture.jpg', 'renovation-plomberie.webp']],
        ];

        foreach ($map as $slug => $files) {
            $service = Service::query()->where('slug', $slug)->first();

            if (! $service) {
                continue;
            }

            $service->clearMediaCollection('image');
            $service->addMedia($this->assetsPath.'/'.$files['image'])
                ->preservingOriginal()
                ->toMediaCollection('image');

            $service->clearMediaCollection('gallery');
            foreach ($files['gallery'] as $file) {
                $service->addMedia($this->assetsPath.'/'.$file)
                    ->preservingOriginal()
                    ->toMediaCollection('gallery');
            }
        }
    }

    protected function seedRealisations(): void
    {
        $realisations = [
            [
                'title' => 'Cuisine ouverte sur mesure',
                'service' => 'renovation-salle-de-bain-cuisine',
                'city' => 'Argenteuil',
                'photo' => 'cuisine-2.jpg',
                'description' => "Conception et pose complète d'une cuisine ouverte sur le séjour, pensée pour un espace de vie lumineux et convivial. L'agencement en L a été optimisé pour libérer de la circulation autour de l'îlot central, avec des façades sombres contrastant avec un plan de travail clair. Raccordements plomberie et électricité, pose de l'électroménager et finitions ont été assurés de bout en bout par notre équipe.",
                'surface' => '12 m²',
                'featured' => true,
            ],
            [
                'title' => 'Salle de bain confort',
                'service' => 'renovation-salle-de-bain-cuisine',
                'city' => 'Sannois',
                'photo' => 'salle-de-bain-2.jpg',
                'description' => "Rénovation complète d'une salle de bain avec remplacement de la baignoire par une douche à l'italienne, pose d'une faïence grand format et d'un meuble vasque sur mesure. Les réseaux de plomberie et l'étanchéité ont été entièrement repris avant la pose des revêtements, pour un résultat durable sur une petite surface.",
                'surface' => '5 m²',
                'featured' => true,
            ],
            [
                'title' => 'Accès PMR sur mesure',
                'service' => 'amenagement-pmr',
                'city' => 'Ermont',
                'photo' => 'pmr-1.jpg',
                'description' => "Aménagement d'un accès PMR sécurisé à l'entrée du logement : rampe sur mesure adaptée à la déclivité du terrain, main courante et revêtement antidérapant. Le projet a fait l'objet d'une étude technique préalable pour garantir une pente conforme et un usage confortable au quotidien.",
                'surface' => null,
                'featured' => true,
            ],
            [
                'title' => 'Rénovation intérieure complète',
                'service' => 'renovation-interieure',
                'city' => 'Franconville',
                'photo' => 'renovation-peinture.jpg',
                'description' => "Travaux de peinture et de finitions intérieures dans le cadre d'une rénovation complète de l'appartement : traitement des murs et plafonds, reprise des plinthes et des encadrements de menuiserie, avant remise en état des sols. Chantier coordonné avec les autres corps de métier pour respecter le planning global.",
                'surface' => null,
                'featured' => false,
            ],
        ];

        foreach ($realisations as $index => $data) {
            $realisation = Realisation::query()->updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'service_id' => Service::query()->where('slug', $data['service'])->value('id'),
                    'city_id' => City::query()->where('slug', \Illuminate\Support\Str::slug($data['city']))->value('id'),
                    'description' => $data['description'],
                    'surface' => $data['surface'],
                    'is_featured' => $data['featured'],
                    'is_published' => true,
                    'order' => $index,
                ]
            );

            $realisation->clearMediaCollection('after');
            $realisation->addMedia($this->assetsPath.'/'.$data['photo'])
                ->preservingOriginal()
                ->toMediaCollection('after');
        }
    }
}
