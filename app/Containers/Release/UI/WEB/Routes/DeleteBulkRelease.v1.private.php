<?php

/** @var Route $router */
$router->delete('releases/delete', [
  'as' => 'web_release_delete_bulk',
  'uses' => 'Controller@deleteBulk',
  'middleware' => [
    'auth:web',
  ],
]);