<?php

namespace Tests\Browser;
use App\Models\Category;
use App\Models\User;
use App\Services\CategoryFactory;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = User::factory()->create([
            'email' => 'danko@sportret.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }

    public function test_can_see_confirm_dialog_box_when_try_to_delete_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                ->click('#delete-category-confirmation')
                ->dismissDialog()
                ->assertSeeIn('#delete-category-confirmation', 'Delete');
        });
    }

    public function test_can_see_correct_message_after_deleting_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                ->click('#delete-category-confirmation')
                ->acceptDialog()
                ->assertSee('Category was deleted')
                ->assertDontSeeIn('ul.dropdown > li:nth-child(2) > a', 'Football')
                ->assertPathIs('/delete-category/1');
        });
    }

    public function test_can_see_edit_and_delete_links()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/show-category/1');
            $h5 = $browser->element('div.basic-card-content h5')->getAttribute('innerHTML');
                $browser->assertSeeLink('Football')
                ->assertSee($h5)
                ->assertSee('Desc of Football')
                ->click();
        });
    }

    public function test_can_see_edit_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/show-category/1')
                ->click('a[href="/edit-category/1"]')
                ->assertPathIs('/edit-category/1')
                ->assertSee('Desc of Football')
                ->assertSee('Edit category');
        });
    }

    public function test_can_see_populated_form_data_on_category_edit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-category/1')
                ->assertSee('Edit category');
            $this->assertTrue(count($browser->driver->findElements(WebDriverBy::xpath('//*[@id="delete-category-confirmation"]'))) > 0);
            $this->assertEquals('Football', $browser->element('input[name="name"]')->getAttribute('value'));
            $this->assertEquals('Desc of Football', trim($browser->element('textarea[name="description"]')->getAttribute('value')));
        });
    }

    public function test_can_see_form_validation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                ->press('Save category')
                ->assertSee('Fill correctly the form');

            $browser->back();

            $browser->type('name', 'Danko')
                    ->type('description', 'Category description')
                    ->press('Save category')
                    ->assertSee('Category was saved');
        });
    }

    public function test_can_see_nested_categories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category');
            $this->assertEquals(8, count($browser->elements('ul.dropdown li')));
            $browser->assertSeeIn('ul.dropdown > li:nth-child(2) > a', 'Football');
            $browser->assertSeeIn('ul.dropdown > li:nth-child(4) > a', 'Videos');
            $browser->assertSeeIn('ul.dropdown > li:nth-child(5) > a', 'Software');
          //  $browser->assertSeeIn('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a', 'Monitors');
        });
    }

    public function test_can_see_select_option_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                    ->assertSee('Basketball');
        });
    }

    public function test_can_see_correct_id_in_select_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-category/2')
                ->assertSee('Basketball');
            $this->assertEquals(2, $browser->element('#selected-category-list')->getAttribute('value'));
        });
    }

    public function test_can_see_category_id_to_be_edited()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-category/2')
                ->assertSourceHas('input type="hidden" name="category_id"')
                ->visit('/show-category/2')
                ->assertSourceMissing('input type="hidden" name="category_id"');
        });
    }

    public function test_can_edit_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/edit-category/2')
                    ->type('name', 'Handball')
                    ->type('description', 'Desc of Handball')
                    ->press('Save category')
                    ->visit('/show-category/2')
                    ->assertDontSee('Basketball')
                    ->assertSee('Handball');
        });
    }

    public function test_can_add_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category')
                ->type('name', 'Tennis')
                ->type('description', 'Desc of Tennis')
                ->press('Save category')
                ->visit('/show-category/3')
                ->assertSee('Tennis');
        });
    }
}
