<?php

$router->get('/logout', [
  'as' => 'get_user_logout_page',
  'uses' => 'Controller@showUserLogoutPage',
]);