<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;

/**
 * Class CreateReleasetest.
 *
 * @group release
 * @group web
 */
class CreateReleasetest extends WebTestCase
{

  // the endpoint to be called within this test (e.g., get@v1/users)
  protected $endpoint = '/releases/store';

  // fake some access rights
  protected $access = [
    'permissions' => '',
    'roles'       => '',
  ];

  // protected $auth = false;

  /**
   * @testCreateNewReleaseSuccess_
   */
  public function testCreateNewReleaseSuccess_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the direct to the correct route
    $response->assertRedirect('/releases/new');

    // assert session success
    $response->assertSessionHas('success');

    // assert the data was stored in the database
    $this->assertDatabaseHas('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithAllFieldNull_
   */
  public function testCreateNewReleaseWithAllFieldNull_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => '',
      'title_description'  => '',
      'detail_description' => '',
      'date_created'       => '',
      'is_publish'         => '',
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the direct to the correct route
    // $response->assertRedirect('/releases/new');

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['name', 'title_description', 'detail_description', 'date_created', 'is_publish']);

    // assert the session errors are correct
    $messages = session('errors')->getMessages();
    $this->assertEquals($messages['name'][0], 'The name field is required.');
    $this->assertEquals($messages['title_description'][0], 'The title description field is required.');
    $this->assertEquals($messages['detail_description'][0], 'The detail description field is required.');
    $this->assertEquals($messages['date_created'][0], 'The date created field is required.');
    $this->assertEquals($messages['is_publish'][0], 'The is publish field must be true or false.');

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithoutData_
   */
  public function testCreateNewReleaseWithoutData_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // send the HTTP request
    $response = $this->post($this->endpoint);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['name', 'title_description', 'detail_description', 'date_created']);

    // assert the session errors are correct
    $messages = session('errors')->getMessages();
    $this->assertEquals($messages['name'][0], 'The name field is required.');
    $this->assertEquals($messages['title_description'][0], 'The title description field is required.');
    $this->assertEquals($messages['detail_description'][0], 'The detail description field is required.');
    $this->assertEquals($messages['date_created'][0], 'The date created field is required.');
    // $this->assertEquals($messages['is_publish'][0], 'The is publish field must be true or false.');
  }

  /**
   * @testCreateNewReleaseWithoutName_
   */
  public function testCreateNewReleaseWithoutName_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      // 'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['name']);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      // 'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithoutTitleDescription_
   */
  public function testCreateNewReleaseWithoutTitleDescription_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      // 'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['title_description']);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      // 'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithoutDetailDescription_
   */
  public function testCreateNewReleaseWithoutDetailDescription_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'              => 'test',
      'title_description' => 'test',
      // 'detail_description' => 'test',
      'date_created'      => '2019-01-01',
      'is_publish'        => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['detail_description']);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'              => $data['name'],
      'title_description' => $data['title_description'],
      // 'detail_description' => $data['detail_description'],
      'date_created'      => $data['date_created'],
      'is_publish'        => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithoutDateCreated_
   */
  public function testCreateNewReleaseWithoutDateCreated_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      // 'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['date_created']);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      // 'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithoutIsPublish_
   */
  public function testCreateNewReleaseWithoutIsPublish_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      // 'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    // $response->assertSessionHasErrors(['is_publish']);

    // assert the data was stored in the database with is_publish = 0
    $this->assertDatabaseHas('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => false,
    ]);
  }

  /**
   * @testCreateNewReleaseWithIsPublishNull_
   */
  public function testCreateNewReleaseWithIsPublishNull_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => '',
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response contain the correct message
    $response->assertSessionHasErrors(['is_publish']);


    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithIsPublishNotBoolean_
   */
  public function testCreateNewReleaseWithIsPublishNotBoolean_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 'test',
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response has errors
    $response->assertSessionHasErrors(['is_publish']);

    // assert the response contain the correct message
    $message = session('errors')->get('is_publish')[0];
    $this->assertEquals('The is publish field must be true or false.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithNameShorterThanThreeChar_
   */
  public function testCreateNewReleaseWithNameShorterThanThreeChar_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'te',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response has errors
    $response->assertSessionHasErrors(['name']);

    // assert the response contain the correct message
    $message = session('errors')->get('name')[0];
    $this->assertEquals('The name must be at least 3 characters.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithNameLongerThan40Char_
   */
  public function testCreateNewReleaseWithNameLongerThan40Char_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $name = '';
    for ($i = 0; $i < 41; $i++) {
      $name .= 'a';
    }
    // create data for request
    $data = [
      'name'               => $name,
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response has errors
    $response->assertSessionHasErrors(['name']);

    // assert the response contain the correct message
    $message = session('errors')->get('name')[0];
    $this->assertEquals('The name may not be greater than 40 characters.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithTitleDescriptionShorterThanThreeChar_
   */
  public function testCreateNewReleaseWithTitleDescriptionShorterThanThreeChar_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'te',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // assert the response has errors
    $response->assertSessionHasErrors(['title_description']);

    // assert the response contain the correct message
    $message = session('errors')->get('title_description')[0];
    $this->assertEquals('The title description must be at least 3 characters.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithTitleDescriptionLongerThan255Char_
   */
  public function testCreateNewReleaseWithTitleDescriptionLongerThan255Char_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    $title_description = '';
    for ($i = 0; $i < 256; $i++) {
      $title_description .= 'a';
    }
    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => $title_description,
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // $response->assertRedirect('/releases/new');

    // assert the response has errors
    $response->assertSessionHasErrors(['title_description']);

    // assert the response contain the correct message
    $message = session('errors')->get('title_description')[0];
    $this->assertEquals('The title description may not be greater than 255 characters.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithDetailDescriptionShorterThanThreeChar_
   */
  public function testCreateNewReleaseWithDetailDescriptionShorterThanThreeChar_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'te',
      'date_created'       => '2019-01-01',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // $response->assertRedirect('/releases/new');

    // assert the response has errors
    $response->assertSessionHasErrors(['detail_description']);

    // assert the response contain the correct message
    $message = session('errors')->get('detail_description')[0];
    $this->assertEquals('The detail description must be at least 3 characters.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }

  /**
   * @testCreateNewReleaseWithDateCreatedNotInCorrectFormat_
   */
  public function testCreateNewReleaseWithDateCreatedNotInCorrectFormat_()
  {
    $user = User::find(1);
    $this->actingAs($user);

    // create data for request
    $data = [
      'name'               => 'test',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => 'not a date',
      'is_publish'         => 1,
    ];

    // send the HTTP request
    $response = $this->post($this->endpoint, $data);

    // assert response status is redirection
    $response->assertStatus(302);

    // $response->assertRedirect('/releases/new');

    // assert the response has errors
    $response->assertSessionHasErrors(['date_created']);

    // assert the response contain the correct message
    $message = session('errors')->get('date_created')[0];
    $this->assertEquals('The date created is not a valid date.', $message);

    // assert the data was not stored in the database
    $this->assertDatabaseMissing('releases', [
      'name'               => $data['name'],
      'title_description'  => $data['title_description'],
      'detail_description' => $data['detail_description'],
      'date_created'       => $data['date_created'],
      'is_publish'         => $data['is_publish'],
    ]);
  }
}