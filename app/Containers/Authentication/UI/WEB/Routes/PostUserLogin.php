<?php

$router->post('/login', [
  'as'   => 'post_user_login_form',
  'uses' => 'Controller@loginUser',
  // 'middleware' => [
  //   'throttle:5,5',
  // ],
]);
