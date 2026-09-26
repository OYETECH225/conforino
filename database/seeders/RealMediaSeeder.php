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
                'service' => 'agencement-cuisine',
                'city' => 'Argenteuil',
                'photo' => 'cuisine-2.jpg',
                'description' => "Conception et pose complète d'une cuisine ouverte, agencement optimisé pour un espace de vie lumineux.",
                'surface' => '12 m²',
                'featured' => true,
            ],
            [
                'title' => 'Salle de bain confort',
                'service' => 'agencement-salle-de-bain',
                'city' => 'Sannois',
                'photo' => 'salle-de-bain-2.jpg',
                'description' => "Rénovation complète d'une salle de bain : douche à l'italienne, faïence et meuble sur mesure.",
                'surface' => '5 m²',
                'featured' => true,
            ],
            [
                'title' => 'Accès PMR sur mesure',
                'service' => 'amenagement-pmr',
                'city' => 'Ermont',
                'photo' => 'pmr-1.jpg',
                'description' => "Aménagement d'un accès PMR sécurisé avec rampe et main courante sur mesure.",
                'surface' => null,
                'featured' => true,
            ],
            [
                'title' => 'Rénovation intérieure complète',
                'service' => 'renovation-interieure',
                'city' => 'Franconville',
                'photo' => 'renovation-peinture.jpg',
                'description' => 'Travaux de peinture et finitions intérieures dans le cadre d\'une rénovation complète.',
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
