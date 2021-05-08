<?php

namespace Tests\Browser;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BackendAcceptanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
         parent::setUp();
    }

    /**
     * A Dusk test
     */
    public function test_can_see_correct_strings_on_category_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                    ->assertSee('Football');
        });
    }

    public function test_can_add_child_category()
    {
        $football = Category::where('name', 'Football')->first();

        $football->children()->saveMany([
            new Category(['name' => 'Premier league', 'description' => 'Description of PL']),
            new Category(['name' => 'Bundesliga', 'description' => 'Description of BL']),
            new Category(['name' => 'Serie A', 'description' => 'Description of SA']),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/category');
            $browser->assertSee('Premier league');
        });
    }
}
