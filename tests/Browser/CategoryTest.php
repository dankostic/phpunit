<?php

namespace Tests\Browser;
use App\Models\User;
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
                ->assertSee('Category was deleted');
        });
    }

    public function test_can_see_edit_and_delete_links()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/category');
            $h5 = $browser->element('div.basic-card-content h5')->getAttribute('innerHTML');
                $browser->assertSeeLink('Electronics')
                ->assertSee($h5)
                ->click();
        });
    }

    public function test_can_see_edit_category()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/show-category/1')
                ->click('a[href="/edit-category/1"]')
                ->assertPathIs('/edit-category/1')
                ->assertSee('Edit category');
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
            $this->assertEquals(18, count($browser->elements('ul.dropdown li')));
            $browser->assertSeeIn('ul.dropdown > li:nth-child(2) > a', 'Electronics');
            $browser->assertSeeIn('ul.dropdown > li:nth-child(3) > a', 'Videos');
            $browser->assertSeeIn('ul.dropdown > li:nth-child(4) > a', 'Software');
            $browser->assertSeeIn('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a', 'Monitors');
        });
    }
}
