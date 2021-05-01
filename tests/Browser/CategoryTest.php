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
            'email' => 'taylor@laravel.com',
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
                ;
        });
    }
}
