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

Route::prefix('role')->group(function () {
  Route::post('/assign', [
    'as' => 'assign_user_to_role',
    'uses' => 'Controller@assignUserToRole',
  ]);

  Route::post('/revoke', [
    'as' => 'revoke_user_from_role',
    'uses' => 'Controller@revokeUserFromRole',
  ]);
});


// $router->post('/user', function() {
//   return 'Hello World';
// });
