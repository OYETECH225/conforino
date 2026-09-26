<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('adminPages')]
    public function test_admin_pages_load(string $uri): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web')
            ->get($uri)
            ->assertOk();
    }

    public static function adminPages(): array
    {
        return [
            ['/admin/pages'],
            ['/admin/pages/create'],
            ['/admin/services'],
            ['/admin/services/create'],
            ['/admin/cities'],
            ['/admin/cities/create'],
            ['/admin/reviews'],
            ['/admin/reviews/create'],
            ['/admin/redirects'],
            ['/admin/redirects/create'],
            ['/admin/realisations'],
            ['/admin/realisations/create'],
            ['/admin/manage-general-settings'],
        ];
    }
}
