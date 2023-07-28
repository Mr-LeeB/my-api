<?php

/** @var Route $router */
$router->post('releases/search', [
  'as' => 'web_release_search',
  'uses' => 'Controller@search',
  'middleware' => [
    'auth:web',
  ],
]);