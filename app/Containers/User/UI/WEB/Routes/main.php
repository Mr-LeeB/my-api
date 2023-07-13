<?php

$router->get('/user', [
  'as' => 'get_user_home_page',
  'uses' => 'Controller@sayWelcome',
]);

// Route::prefix('user')->group(function () {
//   Route::get('/', [
//     'as' => 'get_user_home_page',
//     'uses' => 'Controller@sayWelcome',
//   ]);

//   /** @var Route $router */
//   Route::get('/register', [
//     'as' => 'get_user_register_page',
//     'uses' => 'Controller@showUserRegisterPage',
//   ]);
// });
