<?php

/** @var Route $router */
$router->get('releases/create', [
    'as' => 'web_release_create',
    'uses'  => 'Controller@create',
    'middleware' => [
      'auth:web',
    ],
]);
