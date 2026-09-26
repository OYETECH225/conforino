<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

/**
 * Vrais avis Google laissés par des clients de CONFOR'INO, repris du widget
 * Trustindex embarqué sur l'ancien site (conforino.fr) — noms, notes, dates
 * et textes authentiques, aucun avis inventé.
 */
class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['author_name' => 'Marc Taalbi', 'text' => "Une entreprise de qualité qui m'a donné entière satisfaction et que je recommande.", 'rating' => 5, 'review_date' => '2024-09-18'],
            ['author_name' => 'Didier Chipan Salondy', 'text' => "Société très professionnelle pour l'aménagement d'une douche PMR. Mr TALHA est très compétent. Je recommande", 'rating' => 5, 'review_date' => '2024-08-23'],
            ['author_name' => 'Antonio de Gouveia', 'text' => 'Personne très serviable et très pro qui a su faire le nécessaire. Je ferai à nouveau appel à cette société.', 'rating' => 5, 'review_date' => '2024-06-04'],
            ['author_name' => 'Bernard H.', 'text' => "Très professionnel et cherchant la meilleure solution pour s'adapter aux clients. Transparent et honnête dans sa tarification.", 'rating' => 5, 'review_date' => '2024-05-05'],
            ['author_name' => 'Béatrice Messinger', 'text' => 'Très satisfaite de votre prestation et ne manquerai pas assurément de faire appel à vos services.', 'rating' => 5, 'review_date' => '2024-04-15'],
            ['author_name' => 'Xander King', 'text' => "Je tiens à exprimer ma sincère gratitude pour son travail exceptionnel dans l'installation de la douche et des toilettes dans mon appartement. Son professionnalisme, son expertise et son souci du détail ont vraiment fait la différence. Grâce à lui, je peux désormais profiter d'un espace de vie confortable et fonctionnel.", 'rating' => 5, 'review_date' => '2024-03-12'],
            ['author_name' => 'Ghilbane Said Ali', 'text' => 'Excellent. Travail de pro bien fait.', 'rating' => 5, 'review_date' => '2024-03-11'],
            ['author_name' => 'Salomé Dossavi', 'text' => "Monsieur Talha a été super ! Nous avions commandé un meuble pour notre salle de bain, le service a été super !! Salah a effectué des travaux et m'a été d'une grande aide !! Je recommande à 200 % !", 'rating' => 5, 'review_date' => '2024-02-01'],
            ['author_name' => 'Walid B.', 'text' => "Cette entreprise a réalisé l'ensemble des travaux de nos bureaux. Un travail de qualité.", 'rating' => 5, 'review_date' => '2023-10-29'],
            ['author_name' => 'Mame Sene', 'text' => 'Équipe très professionnelle, rigoureuse, respectueuse des délais de travaux et cela est très plaisant. Je recommande vivement !', 'rating' => 5, 'review_date' => '2023-03-07'],
        ];

        foreach ($reviews as $index => $data) {
            Review::query()->updateOrCreate(
                ['author_name' => $data['author_name'], 'review_date' => $data['review_date']],
                [
                    'text' => $data['text'],
                    'rating' => $data['rating'],
                    'source' => 'google',
                    'is_published' => true,
                    'is_featured' => $index < 4,
                    'order' => $index,
                ]
            );
        }
    }
}
