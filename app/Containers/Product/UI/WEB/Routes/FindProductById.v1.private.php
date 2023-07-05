<?php

/** @var Route $router */
$router->get('products/{id}', [
    'as' => 'web_product_show',
    'uses'  => 'Controller@show',
    'middleware' => [
      'auth:web',
    ],
]);
