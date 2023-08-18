<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;
use App\Containers\Release\Models\Release;

/**
 * Class GetAllReleaseTest.
 *
 * @group release
 * @group web
 */
class GetAllReleaseTest extends WebTestCase
{

  // the endpoint to be called within this test (e.g., get@v1/users)
  protected $endpoint = '/releases';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles'       => '',
  ];

  /**
   * @testGetAllRelease_
   */
  public function testGetAllRelease_()
  {
    $user = factory(User::class)->create();
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->get($this->endpoint);

    // assert the response status
    $response->assertStatus(200);

  }

  /**
   * @testGetAllReleaseWithAdminRole_
   */
  public function testGetAllReleaseWithAdminRole_()
  {
    $user = User::find(1);
    $user->assignRole('admin');
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->get($this->endpoint);

    // assert the response status
    $response->assertStatus(200);

  }

  /**
   * @testGetAllReleaseWithClientRole_
   */
  public function testGetAllReleaseWithClientRole_()
  {
    $user = factory(User::class)->create();
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->get($this->endpoint);

    // assert the response status
    $response->assertStatus(200);

  }

  /**
   * @testGetOneRelease_
   */
  public function testGetOneRelease_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->get($this->endpoint . '/' . $release[0]->id);

    // assert the response status
    $response->assertStatus(200);
  }

  /**
   * @testSearchReleaseByName_
   */
  public function testSearchReleaseByName_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->post($this->endpoint . '/search', ['name' => $release[0]->name]);

    // assert the response status
    $response->assertStatus(200);
  }

  /**
   * @testSearchReleaseById_
   */
  public function testSearchReleaseById_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->post($this->endpoint . '/search/id', ['id' => $release[0]->id]);

    // assert the response status
    $response->assertStatus(200);
  }

  /**
   * @testSearchReleaseByDate_
   */
  public function testSearchReleaseByDate_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();
    // send the HTTP request
    $response = $this->post($this->endpoint . '/search/date', ['date' => $release[0]->date]);

    // assert the response status
    $response->assertStatus(200);
  }

}