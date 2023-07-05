<?php

namespace Tests\Browser;

use App\Containers\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{

  use DatabaseMigrations;
  /**
   * A basic browser test example.
   *
   * @return void
   */
  public function testBasicExample()
  {
    $user = factory(User::class)->create([
      'email' => 'Basic4@laravel.com',
    ]);

    $this->browse(function ($browser) use ($user) {
      $browser->visit('/login')
        ->type('email', $user->email)
        ->type('password', 'password')
        ->press('Login')
        ->assertPathIs('/userdashboard');

      $browser->logout();
    });
  }
}