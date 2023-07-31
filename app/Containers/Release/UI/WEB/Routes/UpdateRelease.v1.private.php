<?php

/** @var Route $router */
$router->put('releases/{id}', [
  'as' => 'web_release_update',
  'uses' => 'Controller@update',
  'middleware' => [
    'auth:web',
  ],
]);