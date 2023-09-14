<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;
use App\Containers\Release\Models\Release;
use Illuminate\Support\Facades\Storage;

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
     * @test
     */
    public function testGetAllReleaseWithAdminRole_()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Storage::fake('public');
        $release = factory(Release::class, 6)->create();

        // send the HTTP request
        $response = $this->get($this->endpoint);

        // assert the response status
        $response->assertStatus(200);
        Storage::fake('public');

    }

    /**
     * @test
     */
    public function testGetAllReleaseWithClientRole_()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $release = factory(Release::class, 6)->create();
        // send the HTTP request
        $response = $this->get($this->endpoint);

        // assert the response status
        $response->assertStatus(403);

        Storage::fake('public');
    }

    /**
     * @testGetOneRelease_
     */
    public function testGetOneRelease_()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Storage::fake('public');
        $release = factory(Release::class, 6)->create();
        // send the HTTP request
        $response = $this->get($this->endpoint . '/' . $release[0]->id);

        // assert the response status
        $response->assertStatus(200);
        Storage::fake('public');
    }

    /**
     * @test
     */
    public function testSearchReleaseByName_()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Storage::fake('public');
        $release = factory(Release::class, 6)->create();
        // send the HTTP request
        $response = $this->post($this->endpoint . '/search', ['name' => $release[0]->name]);

        // assert the response status
        $response->assertStatus(200);
        Storage::fake('public');
    }

    /**
     * @test
     */
    public function testSearchReleaseById_()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Storage::fake('public');
        $release = factory(Release::class, 6)->create();
        // send the HTTP request
        $response = $this->post($this->endpoint . '/search/id', ['id' => $release[0]->id]);

        // assert the response status
        $response->assertStatus(200);
        Storage::fake('public');
    }

    /**
     * @test
     */
    public function testSearchReleaseByDate_()
    {
        $user = User::find(1);
        $this->actingAs($user);

        Storage::fake('public');
        $release = factory(Release::class, 6)->create();
        // send the HTTP request
        $response = $this->post($this->endpoint . '/search/date', ['date' => $release[0]->date]);

        // assert the response status
        $response->assertStatus(200);
        Storage::fake('public');
    }
}