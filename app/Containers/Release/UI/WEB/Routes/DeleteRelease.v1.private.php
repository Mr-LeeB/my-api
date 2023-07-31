<?php

/** @var Route $router */
$router->delete('releases/{id}/delete', [
  'as' => 'web_release_delete',
  'uses' => 'Controller@delete',
  'middleware' => [
    'auth:web',
  ],
]);