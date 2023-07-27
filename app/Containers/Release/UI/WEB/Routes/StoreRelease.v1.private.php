<?php

/** @var Route $router */
$router->post('releases/store', [
    'as' => 'web_release_store',
    'uses'  => 'Controller@store',
    'middleware' => [
      'auth:web',
    ],
]);
