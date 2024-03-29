<?php

namespace App\Containers\Authentication\Providers;

use App\Containers\Authentication\Middlewares\RedirectIfAuthenticated;
use App\Containers\Authentication\Middlewares\WebAuthentication;
use App\Ship\Parents\Providers\MiddlewareProvider;
use \Illuminate\Routing\Middleware\ThrottleRequests;

/**
 * Class MiddlewareServiceProvider
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class MiddlewareServiceProvider extends MiddlewareProvider
{

  /**
   * Register Middleware's
   *
   * @var  array
   */
  protected $middlewares = [

  ];
  /**
   * Register Container Middleware Groups
   *
   * @var  array
   */
  protected $middlewareGroups = [
    'web' => [
      // ..
    ],
    'api' => [
      // ..
    ],
  ];

  protected $routeMiddleware = [
    // apiato User Authentication middleware for Web Pages
    'auth:web' => WebAuthentication::class,
    'throttle' => ThrottleRequests::class,
    'guest' => RedirectIfAuthenticated::class,

    // ..
  ];
}