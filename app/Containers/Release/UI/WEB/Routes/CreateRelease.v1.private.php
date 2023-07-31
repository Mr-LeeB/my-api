<?php

/** @var Route $router */
$router->get('releases/new', [
  'as' => 'web_release_create',
  'uses' => 'Controller@create',
  'middleware' => [
    'auth:web',
  ],
]);