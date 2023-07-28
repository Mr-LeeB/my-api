<?php

/** @var Route $router */
$router->post('releases/search/id', [
  'as' => 'web_release_search_by_id',
  'uses' => 'Controller@searchById',
  'middleware' => [
    'auth:web',
  ],
]);