<?php

/** @var Route $router */
$router->get('releases', [
  'as' => 'web_release_get_all_release',
  'uses' => 'Controller@getAllRelease',
  'middleware' => [
    'auth:web',
  ],
]);