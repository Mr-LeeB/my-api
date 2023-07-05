<?php

/** @var Route $router */
$router->get('products', [
    'as' => 'web_product_index',
    'uses'  => 'Controller@index',
    'middleware' => [
      'auth:web',
    ],
]);
