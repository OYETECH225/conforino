<?php

namespace Tests\Feature;

use Database\Seeders\CitySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\RedirectSeeder;
use Database\Seeders\SanitaryServiceSeeder;
use Database\Seeders\ServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([CitySeeder::class, ServiceSeeder::class, PageSeeder::class, SanitaryServiceSeeder::class, RedirectSeeder::class]);
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_load(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public static function publicPages(): array
    {
        return [
            ['/'],
            ['/services'],
            ['/services/renovation-salle-de-bain-cuisine'],
            ['/services/amenagement-pmr'],
            ['/services/amenagement-pmr-argenteuil'],
            ['/services/renovation-interieure'],
            ['/a-propos'],
            ['/realisations'],
            ['/installation-sanitaire'],
            ['/installation-sanitaire/tarifs'],
            ['/installation-sanitaire/robinet-cuisine'],
            ['/installation-sanitaire/pare-baignoire'],
            ['/zones-d-intervention'],
            ['/faq'],
            ['/contact'],
            ['/mentions-legales'],
            ['/politique-de-confidentialite'],
            ['/protection-du-consommateur'],
            ['/conditions-generales-de-vente'],
            ['/sitemap.xml'],
            ['/robots.txt'],
        ];
    }

    #[DataProvider('sanitaryPages')]
    public function test_sanitary_pages_render_contact_form(string $uri): void
    {
        $this->get($uri)
            ->assertOk()
            ->assertSee('id="devis"', false)
            ->assertDontSee('<x-render-blocks', false);
    }

    public static function sanitaryPages(): array
    {
        return [
            ['/installation-sanitaire'],
            ['/installation-sanitaire/tarifs'],
            ['/installation-sanitaire/robinet-cuisine'],
            ['/installation-sanitaire/pare-baignoire'],
        ];
    }

    public function test_homepage_has_exactly_one_h1(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertSame(1, substr_count($html, '<h1'));
    }

    public function test_legacy_url_redirects_permanently(): void
    {
        $this->get('/services/entreprise-cuisine-95/')
            ->assertRedirect('/services/renovation-salle-de-bain-cuisine')
            ->assertStatus(301);
    }

    public function test_contact_form_requires_explicit_consent(): void
    {
        \Livewire\Livewire::test(\App\Livewire\ContactForm::class)
            ->set('name', 'Jean Test')
            ->set('phone', '0600000000')
            ->set('consent', false)
            ->call('submit')
            ->assertHasErrors(['consent']);

        $this->assertDatabaseCount('contact_requests', 0);
    }

    public function test_contact_form_submits_with_consent(): void
    {
        \Livewire\Livewire::test(\App\Livewire\ContactForm::class)
            ->set('name', 'Jean Test')
            ->set('phone', '0600000000')
            ->set('consent', true)
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('contact_requests', 1);
    }
}
