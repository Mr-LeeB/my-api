<?php

/** @var Route $router */
$router->get('products/create', [
    'as' => 'web_product_create',
    'uses'  => 'Controller@create',
    'middleware' => [
      'auth:web',
    ],
]);
