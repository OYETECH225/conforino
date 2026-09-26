<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@conforino.fr'],
            [
                'name' => "Admin CONFOR'INO",
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            CitySeeder::class,
            ServiceSeeder::class,
            ReviewSeeder::class,
            PageSeeder::class,
            RealMediaSeeder::class,
            RedirectSeeder::class,
        ]);
    }
}
