<?php

namespace App\Containers\Release\UI\WEB\Tests\Functional;

use App\Containers\Release\Tests\WebTestCase;
use App\Containers\User\Models\User;
use App\Containers\Release\Models\Release;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Containers\Release\Data\Repositories\ReleaseRepository;

/**
 * Class CreateReleasetest.
 *
 * @group release
 * @group web
 */
class CreateReleasetest extends WebTestCase
{
    // use RefreshDatabase;

    // the endpoint to be called within this test (e.g., get@v1/users)
    protected $endpoint = '/releases/store';

    // fake some access rights
    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @testLoadCreateNewReleasePageWithAdmin_
     */
    public function testLoadCreateNewReleasePageWithAdmin_()
    {
        $user = User::find(1);
        $this->actingAs($user);
        // send the HTTP request
        $response = $this->get('/releases/new');

        // assert response status is correct
        $response->assertStatus(200);

        // assert we're hitting the correct route
        $response->assertViewIs('release::admin.admin-create-release-page');
    }

    /**
     * @testLoadCreateNewReleasePageWithoutAdmin_
     */
    public function testLoadCreateNewReleasePageWithoutAdmin_()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        // send the HTTP request
        $response = $this->get('/releases/new');

        // assert response status is correct
        $response->assertStatus(403);
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
     * Required store data validation provider.
     *
     * @codeCoverageIgnore
     * 
     * @return \string[][]
     */
    public function dataCreateRelease(): array
    {
        $file = UploadedFile::fake()->image('release.jpg', 100, 100);

        return [
            'Create new release success'                                 => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],

            'Create release with null values'                            => [
                [
                    'name'               => '',
                    'title_description'  => '',
                    'detail_description' => '',
                    'is_publish'         => '',
                    'images'             => [],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                        'title_description',
                        'detail_description',
                        'is_publish'
                    ],
                ],
            ],
            'Create Release With Existed name'                           => [
                [
                    'name'               => 'test update release',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                    ],
                ],
            ],
            'Create release without field'                               => [
                [
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                        'title_description',
                        'detail_description',
                    ],
                ],
            ],
            'Create release without name'                                => [
                [
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                    ],
                ],
            ],
            'Create release without title_description'                   => [
                [
                    'name'               => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'title_description',
                    ],
                ],
            ],
            'Create release without detail_description'                  => [
                [
                    'name'              => 'test',
                    'title_description' => 'test',
                    'is_publish'        => 1,
                    'images'            => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'detail_description',
                    ],
                ],
            ],
            'Create release without is_publish'                          => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with is_publish null'                        => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => '',
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'is_publish',
                    ],
                ],
            ],
            'Create release with is_publish not boolean'                 => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 'test',
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'is_publish',
                    ],
                ],
            ],
            'Create release with name shorter than 3 char'               => [
                [
                    'name'               => 'te',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                    ],
                ],
            ],
            'Create release with name lenght is 3 char'                  => [
                [
                    'name'               => 'tes',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with name longer than 40 char'               => [
                [
                    'name'               => str_repeat('a', 41),
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'name',
                    ],
                ],
            ],
            'Create release with name lenght is 40 char'                 => [
                [
                    'name'               => str_repeat('a', 40),
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with title_description shorter than 3 char'  => [
                [
                    'name'               => 'test',
                    'title_description'  => 'te',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'title_description',
                    ],
                ],
            ],
            'Create release with title_description lenght is 3 char'     => [
                [
                    'name'               => 'test',
                    'title_description'  => 'tes',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with title_description longer than 255 char' => [
                [
                    'name'               => 'test',
                    'title_description'  => str_repeat('a', 256),
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],
                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'title_description',
                    ],
                ],
            ],
            'Create release with title_description lenght is 255 char'   => [
                [
                    'name'               => 'test',
                    'title_description'  => str_repeat('a', 255),
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with detail_description shorter than 3 char' => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'te',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'detail_description',
                    ],
                ],
            ],
            'Create release with detail_description lenght is 3 char'    => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'tes',
                    'is_publish'         => 1,
                    'images'             => [$file],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with image is not array'                     => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => $file,
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'images',
                    ],
                ],
            ],
            'Create release with image is not incorrect format'          => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => ['test'],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'images.0',
                    ],
                ],
            ],
            'Create release with image size larger than 6MB'             => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [
                        UploadedFile::fake()->image('release.jpg', 100, 100)->size(7000),
                        UploadedFile::fake()->image('release.jpg', 100, 100)->size(7000),
                    ],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'images.0',
                        'images.1',
                    ],
                ],
            ],
            'Create release with image size is 6MB'                      => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [
                        UploadedFile::fake()->image('release.jpg', 100, 100)->size(6144),
                        UploadedFile::fake()->image('release.jpg', 100, 100)->size(6144),
                    ],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'success',
                    'fieldHasError' => [
                    ],
                ],
            ],
            'Create release with image is not support'                   => [
                [
                    'name'               => 'test',
                    'title_description'  => 'test',
                    'detail_description' => 'test',
                    'is_publish'         => 1,
                    'images'             => [UploadedFile::fake()->image('release.zip', 100, 100)->size(6144)],
                ],

                'assert' => [
                    'status'        => 302,
                    'route'         => '/releases/new',
                    'session'       => 'errors',
                    'fieldHasError' => [
                        'images.0',
                    ],
                ],
            ],
        ];
    }

    /**
     * @test
     * 
     * @dataProvider dataCreateRelease
     */
    public function testCreateNewRelease_($data, $assert)
    {
        $user = User::find(1);

        $this->actingAs($user);

        Storage::fake('public');

        $this->from('/releases/new');

        factory(Release::class)->create([
            'name' => 'test update release',
        ]);

        // send the HTTP request
        $response = $this->post($this->endpoint, $data);

        // assert response status is redirection
        $response->assertStatus($assert['status']);

        // assert the direct to the correct route
        $response->assertRedirect($assert['route']);

        // assert session success
        $response->assertSessionHas($assert['session']);

        // assert the data was stored in the database
        if ($assert['session'] == 'success') {
            $this->assertDatabaseHas('releases', [
                'name'               => $data['name'],
                'title_description'  => $data['title_description'],
                'detail_description' => $data['detail_description'],
            ]);
        } else {
            $response->assertSessionHasErrors($assert['fieldHasError']);
            $this->assertDatabaseMissing('releases', [
                'name'               => $data['name'] ?? '',
                'title_description'  => $data['title_description'] ?? '',
                'detail_description' => $data['detail_description'] ?? '',
            ]);
        }

        Storage::fake('public');
    }
}