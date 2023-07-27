<?php

namespace App\Containers\Product\UI\API\Tests\Functional;

use App\Containers\Product\Tests\ApiTestCase;

/**
 * Class CreateProductFunctionalTest.
 *
 * @group product
 * @group api
 */
class CreateProductFunctionalTest extends ApiTestCase
{

  // the endpoint to be called within this test (e.g., get@v1/users)
  protected $endpoint = 'method@endpoint';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles' => '',
  ];

  /**
   * @test
   */
  public function test_()
  {
    $data = [
      // 'key' => 'value',
    ];

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert the response status
    $response->assertStatus(200);

    // make other asserts here
  }

}