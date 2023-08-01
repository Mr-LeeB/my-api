<?php

/** @var Route $router */
$router->get('releases/{id}', [
  'as' => 'web_release_show_detail_release',
  'uses' => 'Controller@showDetailRelease',
  'middleware' => [
    'auth:web',
  ],
]);