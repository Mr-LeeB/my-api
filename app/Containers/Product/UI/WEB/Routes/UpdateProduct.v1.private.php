<?php

/** @var Route $router */
$router->patch('products/{id}', [
    'as' => 'web_product_update',
    'uses'  => 'Controller@update',
    'middleware' => [
      'auth:web',
    ],
]);
