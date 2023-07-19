<?php

$router->get('/user', [
  'as' => 'get_user_home_page',
  'uses' => 'Controller@sayWelcome',
]);

Route::prefix('user')->group(function () {
  Route::post('/', [
    'as' => 'find_user_by_id',
    'uses' => 'Controller@findUserById',
  ]);
});

// $router->post('/user', function() {
//   return 'Hello World';
// });