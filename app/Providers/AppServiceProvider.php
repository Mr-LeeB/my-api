<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    // Register the 'jsonb' type if it hasn't been registered yet
    if (!Type::hasType('json')) {
      Type::addType('json', \Doctrine\DBAL\Types\JsonArrayType::class);
    }
  }
}