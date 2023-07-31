<?php

namespace App\Containers\User\UI\WEB\Tests\Functional;

use App\Containers\User\Tests\WebTestCase;

/**
 * Class DeleteUserTest.
 *
 * @group user
 * @group web
 */
class DeleteUserTest extends WebTestCase
{

  // the endpoint to be called within this test (e.g., delete@delete/{id})
  protected $endpoint = 'delete@delete/{id}';

  // fake some access rights
  protected $access = [
    'roles' => '',
    'permissions' => 'delete-users',
  ];

  public function testWebDeleteExistingUser_()
  {
    // get the user to be deleted
    $user = $this->getTestingUser();

    // send the HTTP request
    $response = $this->injectId($user->id)->makeCall();

    // assert the response status
    $response->assertStatus(204);
  }
}

?>