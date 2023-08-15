<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use Illuminate\Support\Arr;
use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tests\ApiTestCase;
use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Config;

/**
 * Class AssignUserToRoleTest.
 *
 * @group authorization
 * @group api
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class AssignUserToPermissionTest extends ApiTestCase
{

  protected $endpoint = 'post@v1/permissions/assign';

  protected $access = [
    'roles'       => '',
    'permissions' => 'manage-admins-access',
  ];

  /**
   * @test
   */
  public function testAssignUserToPermission_()
  {
    $randomUser = factory(User::class)->create();

    $permisson = factory(Permission::class)->create();

    $data = [
      'permissions_ids' => [$permisson->getHashedKey()],
      'user_id'         => $randomUser->getHashedKey(),
    ];

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);
    // dd($response->getContent());

    $responseContent = $this->getResponseContentObject();


    // dd($responseContent);

    $this->assertEquals($data['user_id'], $responseContent->data->id);

    // $this->assertEquals($data['permissions_ids'][0], $responseContent->data->roles->data[0]->id);
  }
}