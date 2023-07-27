<?php

/** @var Route $router */
$router->get('releases/{id}/edit', [
    'as' => 'web_release_edit',
    'uses'  => 'Controller@edit',
    'middleware' => [
      'auth:web',
    ],
]);
