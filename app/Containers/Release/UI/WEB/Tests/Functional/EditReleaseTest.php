<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;

/**
 * Class EditReleaseTest.
 *
 * @group release
 * @group web
 */
class EditReleaseTest extends WebTestCase
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
