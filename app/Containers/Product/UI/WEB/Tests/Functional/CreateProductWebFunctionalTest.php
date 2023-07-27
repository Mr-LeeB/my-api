<?php

namespace App\Containers\Product\UI\WEB\Tests\Functional;

use App\Containers\Product\Tests\WebTestCase;

/**
 * Class CreateProductWebFunctionalTest.
 *
 * @group product
 * @group web
 */
class CreateProductWebFunctionalTest extends WebTestCase
{

    // the endpoint to be called within this test (e.g., get@v1/users)
    protected $endpoint = 'method@endpoint';

    // fake some access rights
    protected $access = [
        'permissions' => '',
        'roles'       => '',
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
