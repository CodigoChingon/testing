<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $user = factory(User::class)->create([
            
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertSee('You are logged in!');
        });

        $this->logout();
    }

    public function testLoginFailedWrongUser()
    {
        $this->browse(function (Browser $browser){
            $browser->visit('/login')
                    ->type('email', 'jfwjpfwpoofl')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertSee('Remember Me');
        });
    }

    public function testLoginFailedWrongPassword()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email',  $user->email)
                    ->type('password', 'secrets')
                    ->press('Login')
                    ->assertSee('Remember Me');
        });
    }
    
    private function logout()
    {
        $this->browse(function ($browser) {
            $browser->click('#navbarDropdown')
                    ->click('#navbarSupportedContent > ul.navbar-nav.ml-auto > li > div > a');
        });
    }
}
