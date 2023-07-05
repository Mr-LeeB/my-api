<?php

/** @var Route $router */
$router->delete('products/{id}', [
    'as' => 'web_product_delete',
    'uses'  => 'Controller@delete',
    'middleware' => [
      'auth:web',
    ],
]);
