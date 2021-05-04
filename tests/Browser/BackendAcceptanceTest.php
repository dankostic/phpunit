<?php

namespace Tests\Browser;

use App\Models\Category;
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
        $parent_category = Category::where('name', 'Football')->first();

        $child_category = new Category();
        $child_category->name = "Premier league";

        $parent_category->children()->save($child_category);

        $this->browse(function (Browser $browser) {
            $browser->visit('/category');
            $browser->assertSeeIn('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a', 'Premier league');
        });
    }
}
