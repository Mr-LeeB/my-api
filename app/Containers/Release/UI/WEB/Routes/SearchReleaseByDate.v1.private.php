<?php

/** @var Route $router */
$router->post('releases/search/date', [
  'as' => 'web_release_search_by_date',
  'uses' => 'Controller@searchByDate',
  'middleware' => [
    'auth:web',
  ],
]);