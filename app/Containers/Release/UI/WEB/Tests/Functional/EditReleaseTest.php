<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Models\Release;
use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;

/**
 * Class EditReleaseTest.
 *
 * @group release
 * @group web
 */
class EditReleaseTest extends WebTestCase
{
  // use RefreshDatabase;


  // the endpoint to be called within this test (e.g., get@v1/users)
  protected $endpoint = '/release/{id}';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles'       => '',
  ];

  /**
   * @testLoadEditReleasePage_
   */
  public function testLoadEditReleasePage_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // send the HTTP request
    $response = $this->get($this->endpoint . '/edit');

    // assert response status is correct
    $response->assertStatus(200);

    // assert the response body contains the correct string
    $response->assertSee('Edit Release');
  }

  /**
   * @testUpdateReleaseSuccess_
   */
  public function testUpdateReleaseSuccess_()
  {
    $user = User::find(1);
    $this->actingAs($user);
    $data = [
      'id'                 => '1',
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert the response status
        $response->assertStatus(200);

        // make other asserts here
    }

}
