<?php

/**
 * @apiGroup           Product
 * @apiName            findProductById
 *
 * @api                {GET} /vv1/products/:name Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         v1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

/** @var Route $router */
$router->get('products/name/{name}', [
  'as' => 'api_product_find_product_by_name',
  'uses' => 'Controller@findProductByName',
  'middleware' => [
    'auth:api',
  ],
]);
