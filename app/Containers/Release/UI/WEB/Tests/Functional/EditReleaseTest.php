<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Models\Release;
use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class EditReleaseTest.
 *
 * @group release
 * @group web
 */
class EditReleaseTest extends WebTestCase
{
  // use RefreshDatabase;


  // the endpoint to be called within this test (/releases/{id})
  protected $endpoint = '/releases/{id}';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles'       => 'admin',
  ];

  /**
   * @testLoadEditReleasePage_
   */
  public function testLoadEditReleasePage_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->get($this->endpoint . '/edit');

    // assert response status is correct
    $response->assertStatus(200);

    // assert we are getting the correct view template
    $response->assertViewIs('release::admin.admin-create-release-page');
  }

  /**
   * @testLoadEditReleasePageFail_
   */
  public function testLoadEditReleasePageFail_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // $release = factory(Release::class, 6)->create();
    // dd($release[0]);

    // send the HTTP request
    $response = $this->injectId(999)->get($this->endpoint . '/edit');

    // dd($response);
    // assert response status is correct
    $response->assertStatus(302);
  }

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
   * @testUpdateReleaseSuccess_
   */
  public function testUpdateReleaseSuccess_()
  {
    $user = User::find(1);
    $this->actingAs($user);


    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);


    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHas('success', '<p>Release <strong>' . $data['name'] . '</strong> Updated Successfully</p>');

    // assert the data was stored in the database
    $this->assertDatabaseHas('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullData_
   */
  public function testUpdateReleaseWithNullData_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => '',
      'title_description'  => '',
      'detail_description' => '',
      'date_created'       => '',
      'is_publish'         => '',
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['name', 'title_description', 'detail_description', 'date_created', 'is_publish']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullName_
   */
  public function testUpdateReleaseWithNullName_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => '',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['name']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullTitleDescription_
   */
  public function testUpdateReleaseWithNullTitleDescription_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => '',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['title_description']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullDetailDescription_
   */
  public function testUpdateReleaseWithNullDetailDescription_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => '',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['detail_description']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullDateCreated_
   */
  public function testUpdateReleaseWithNullDateCreated_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['date_created']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithNullIsPublish_
   */
  public function testUpdateReleaseWithNullIsPublish_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => '',
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['is_publish']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithInvalidIsPublish_
   */
  public function testUpdateReleaseWithInvalidIsPublish_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => 'test',
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['is_publish']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithInvalidId_
   */
  public function testUpdateReleaseWithInvalidId_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => 'test',
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $release[0]->id . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithInvalidDateCreated_
   */
  public function testUpdateReleaseWithInvalidDateCreated_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id'                 => $release[0]->id,
      'name'               => 'update',
      'title_description'  => 'update',
      'detail_description' => 'update',
      'date_created'       => 'test',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $data['id'] . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors(['date_created']);

    // assert the data was stored in the database
    $this->assertDatabaseMissing('releases', [
      'id'                 => $data['id'],
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testUpdateReleaseWithoutData_
   */
  public function testUpdateReleaseWithoutData_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $release = factory(Release::class, 6)->create();

    $this->from('releases/' . $release[0]->id . '/edit');
    $data = [
      'id' => $release[0]->id,
    ];

    // send the HTTP request
    $response = $this->injectId($release[0]->id)->put($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    $url = 'releases' . '/' . $release[0]->id . '/edit';

    // assert the direct to the correct route
    $response->assertRedirect($url);

    // assert the response body contains the correct string
    $response->assertSessionHasErrors([
      'title_description',
      'detail_description',
      'date_created',
    ]);
  }
}