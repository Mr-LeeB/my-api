<?php

$router->get('/login', [
  'as'   => 'get_user_login_page',
  'uses' => 'LoginController@showUserLoginPage',
]);
