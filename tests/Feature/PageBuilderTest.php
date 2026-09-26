<?php

namespace Tests\Feature;

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Vérifie que le champ Builder "blocks" (non lié directement à une colonne du
 * modèle Page) est bien synchronisé vers la table `blocks` à la création et
 * à l'édition — c'est le rouage le plus custom du CMS.
 */
class PageBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_page_persists_its_blocks(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreatePage::class)
            ->fillForm([
                'title' => 'Page de test',
                'slug' => 'page-de-test',
                'status' => 'published',
                'blocks' => [
                    [
                        'type' => 'hero',
                        'data' => ['heading' => 'Titre de test', 'subheading' => 'Sous-titre'],
                    ],
                    [
                        'type' => 'rich_text',
                        'data' => ['content' => '<p>Contenu</p>'],
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $page = Page::where('slug', 'page-de-test')->firstOrFail();

        $this->assertCount(2, $page->blocks);
        $this->assertSame('hero', $page->blocks[0]->type);
        $this->assertSame('Titre de test', $page->blocks[0]->data['heading']);
        $this->assertSame('rich_text', $page->blocks[1]->type);
    }

    public function test_editing_a_page_resyncs_its_blocks(): void
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['slug' => 'page-existante', 'status' => 'published']);
        $page->blocks()->create(['type' => 'hero', 'data' => ['heading' => 'Ancien titre'], 'order' => 0]);

        Livewire::actingAs($user)
            ->test(EditPage::class, ['record' => $page->getKey()])
            ->fillForm([
                'blocks' => [
                    ['type' => 'hero', 'data' => ['heading' => 'Nouveau titre']],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $page->refresh();

        $this->assertCount(1, $page->blocks);
        $this->assertSame('Nouveau titre', $page->blocks[0]->data['heading']);
    }
}
