<?php

/** @var Route $router */
$router->delete('releases/{id}', [
    'as' => 'web_release_delete',
    'uses'  => 'Controller@delete',
    'middleware' => [
      'auth:web',
    ],
]);
