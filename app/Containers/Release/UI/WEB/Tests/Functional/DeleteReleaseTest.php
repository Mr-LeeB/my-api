<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;
use App\Containers\Release\Models\Release;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DeleteReleaseTest.
 *
 * @group release
 * @group web
 */
class DeleteReleaseTest extends WebTestCase
{

  // the endpoint to be called within this test (e.g., get@v1/users)
  protected $endpoint = 'delete/{id}';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles'       => 'admin',
  ];

  /**
   * @from
   *
   * @param string $url
   *
   * @return $this
   */
  public function from(string $url)
  {
    $this->app['session']->setPreviousUrl($url);
    return $this;
  }

  /**
   * @testDeleteReleaseSuccess_
   */
  public function testDeleteReleaseSuccess_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $data = [
      'id'   => $release[0]->id,
      'name' => $release[0]->name,
    ];

    $this->from('/releases');

    // send the HTTP request
    $response = $this->delete(route('web_release_delete', $release[0]->id));

    // assert the response status
    $response->assertStatus(302);

    // assert the redirect url
    $response->assertRedirect('/releases');

    // assert the data was deleted from the database
    $this->assertDatabaseMissing('releases', ['id' => $release[0]->id]);

    // assert a session flash message was set
    $response->assertSessionHas('success', '<p style="color:blue">Release <strong>' . $data['name'] . '</strong> Deleted Successfully</p>');
  }

  /**
   * @testDeleteReleaseFail_
   */
  public function testDeleteReleaseFail_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('/releases');

    // send the HTTP request
    $response = $this->delete(route('web_release_delete', 999));

    // assert the response status
    $response->assertStatus(302);

    // assert the redirect url
    $response->assertRedirect('/releases');

    // assert the data was deleted from the database
    $this->assertDatabaseHas('releases', ['id' => $release[0]->id]);

    // assert a session flash message was set
    $response->assertSessionHas('error', '<p style="color:red"> Release Not Found </p>');
  }

  /**
   * testDeleteReleaseWithoutLogin_
   */
  public function testDeleteReleaseWithoutLogin_()
  {
    $release = factory(Release::class, 6)->create();

    $this->from('/releases');

    // send the HTTP request
    $response = $this->delete(route('web_release_delete', $release[0]->id));

    // assert the response status
    $response->assertStatus(401);
  }

  /**
   * testDeleteBulkReleaseSuccess_
   */
  public function testDeleteBulkReleaseSuccess_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $data = [
      'id'   => [$release[0]->id, $release[1]->id, $release[2]->id],
      'name' => $release[0]->name . ', ' . $release[1]->name . ', ' . $release[2]->name,
    ];

    $this->from('/releases');

    // send the HTTP request
    $response = $this->delete(route('web_release_delete_bulk'), $data);

    // assert the response status
    $response->assertStatus(302);

    // assert the redirect url
    $response->assertRedirect('/releases');

    // assert the data was deleted from the database
    $this->assertDatabaseMissing('releases', ['id' => $data['id'][0]]);
    $this->assertDatabaseMissing('releases', ['id' => $data['id'][1]]);
    $this->assertDatabaseMissing('releases', ['id' => $data['id'][2]]);

    // assert a session flash message was set
    $response->assertSessionHas('success', '<p style="color:blue"> Release <strong>' . $data['name'] . '</strong> Deleted Successfully </p>');
  }

  /**
   * testDeleteBulkReleaseFail_
   */
  public function testDeleteBulkReleaseFail_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $data = [
      'id'   => [999, 888, 777],
      'name' => '999, 888, 777',
    ];

    $this->assertDatabaseMissing('releases', ['id' => $data['id'][0]]);
    $this->assertDatabaseMissing('releases', ['id' => $data['id'][1]]);
    $this->assertDatabaseMissing('releases', ['id' => $data['id'][2]]);

    $this->from('/releases');

    // send the HTTP request
    $response = $this->delete(route('web_release_delete_bulk'), $data);

    // assert the response status
    $response->assertStatus(302);

    // assert the redirect url
    $response->assertRedirect('/releases');

    // assert a session flash message was set
    // $response->assertSessionHas('error', '<p style="color:red"> Release(s) Not Found </p>');
  }
}