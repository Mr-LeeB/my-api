<?php

/** @var Route $router */
$router->get('admin-releases', [
  'as' => 'admin_get_all_release',
  'uses' => 'Controller@getAllRelease',
  'middleware' => [
    'auth:web',
  ],
]);