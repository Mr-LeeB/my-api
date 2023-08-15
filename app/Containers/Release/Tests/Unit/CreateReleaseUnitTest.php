<?php

namespace App\Containers\Release\Tests\Unit;

use App\Containers\Release\Actions\CreateReleaseAction;

use App\Containers\Release\Models\Release;
use App\Containers\Release\Tests\TestCase;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

/**
 * Class CreateReleaseUnitTest.
 *
 * @group release
 * @group unit
 */
class CreateReleaseUnitTest extends TestCase
{

  /**
   * @testCreateReleaseSuccess_
   */
  public function testCreateReleaseSuccess_()
  {
    $this->getTestingUser();
    // create a data object
    $data = [
      'name'               => 'test create',
      'title_description'  => 'test',
      'detail_description' => 'test',
      'date_created'       => '2019-01-01',
      'is_publish'         => true,
      'images'             => ['images.jpg'],
    ];

    /**
     * you may want to do something like:
     *
     * 1) create a new Transporter with this data
     * 2) create a specific Action or Task
     * 3) pass the Transporter to the Action / Task
     * 4) assert that everything is correct!
     *
     */

    $transporter = new DataTransporter($data);
    $action      = App::make(CreateReleaseAction::class);
    $release     = $action->run($transporter);

    // assert the returned object is an instance of the Release
    $this->assertInstanceOf(Release::class, $release);

    $this->assertEquals($release->name, $data['name']);

  }
}