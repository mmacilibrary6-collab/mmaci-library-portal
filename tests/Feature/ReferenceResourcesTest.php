<?php

namespace Tests\Feature;

use App\Models\OpenAccessResource;
use App\Models\ReferenceResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReferenceResourcesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        foreach (['2026_07_29_001101_create_open_access_resources_table.php', '2026_09_10_000002_create_reference_resources_table.php'] as $file) {
            (require database_path('migrations/'.$file))->up();
        }
    }

    public function test_admin_crud_and_public_visibility_keep_resource_collections_separate(): void
    {
        $open = OpenAccessResource::create(['title' => 'Open Access Fixture', 'website_url' => 'https://example.com/open', 'is_active' => true]);
        $this->actingAs(new User(['name' => 'Admin']));
        $data = ['title' => 'Research Guide Fixture', 'description' => 'Citation assistance',
            'website_url' => 'https://example.com/guide', 'is_active' => '1'];
        $this->get(route('admin.reference-resources.create'))->assertOk()->assertSee('Reference &amp; Research Assistance', false);
        $this->post(route('admin.reference-resources.store'), $data)
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.reference-resources.index'));
        $resource = ReferenceResource::firstOrFail();
        $this->get(route('admin.reference-resources.index'))->assertOk()->assertSeeText($resource->title)->assertDontSeeText($open->title);
        $this->get(route('admin.reference-resources.edit', $resource))->assertOk()->assertSee($resource->title);
        $this->get(route('admin.open-access-resources.edit', $open))->assertOk()->assertSee($open->title);
        $this->get(route('collection.reference-research'))->assertOk()->assertSeeText($resource->title)->assertDontSeeText($open->title);
        $this->get(route('collection.open-access'))->assertOk()->assertSeeText($open->title)->assertDontSeeText($resource->title);
        $this->put(route('admin.reference-resources.update', $resource), array_replace($data, ['is_active' => '0']))
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.reference-resources.index'));
        $this->get(route('collection.reference-research'))->assertOk()->assertDontSeeText($resource->title);
        $this->delete(route('admin.reference-resources.destroy', $resource))->assertRedirect(route('admin.reference-resources.index'));
        $this->assertSame(0, ReferenceResource::count());
        $this->assertSame(1, OpenAccessResource::count());
    }

    public function test_guests_cannot_manage_reference_resources(): void
    {
        $this->get(route('admin.reference-resources.index'))->assertRedirect();
        $this->post(route('admin.reference-resources.store'), [])->assertRedirect();
        $this->assertSame(0, ReferenceResource::count());
    }
}
