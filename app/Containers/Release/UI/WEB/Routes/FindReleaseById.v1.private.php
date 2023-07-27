<?php

/** @var Route $router */
$router->get('releases/{id}', [
    'as' => 'web_release_show',
    'uses'  => 'Controller@show',
    'middleware' => [
      'auth:web',
    ],
]);
