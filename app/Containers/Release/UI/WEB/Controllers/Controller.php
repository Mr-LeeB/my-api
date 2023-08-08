<?php

namespace App\Containers\Release\UI\WEB\Controllers;

use App\Containers\Release\Models\Release;
use App\Containers\Release\UI\WEB\Requests\CreateReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\DeleteBulkReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\DeleteReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\GetAllReleasesRequest;
use App\Containers\Release\UI\WEB\Requests\FindReleaseByIdRequest;
use App\Containers\Release\UI\WEB\Requests\SearchReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\UpdateReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\StoreReleaseRequest;
use App\Containers\Release\UI\WEB\Requests\EditReleaseRequest;
use App\Ship\Parents\Controllers\WebController;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

/**
 * Class Controller
 *
 * @package App\Containers\Release\UI\WEB\Controllers
 */
class Controller extends WebController
{
  /**
   * Show all entities
   *
   * @param GetAllReleasesRequest $request
   */
  public function getAllRelease(GetAllReleasesRequest $request)
  {
    $releases = Apiato::call('Release@GetAllReleasesAction', [new DataTransporter($request)]);

    $all_Releases_count = Release::all()->count();

    if (auth()->user()->hasAdminRole()) {
      return view('release::admin.admin-show-release-page', compact('releases', 'all_Releases_count'));
    }
    return view('release::client.home', compact('releases', 'all_Releases_count'));
  }

  /**
   * Show one entity
   *
   * @param FindReleaseByIdRequest $request
   */
  public function showDetailRelease(FindReleaseByIdRequest $request)
  {
    $release = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);

    return view('release::admin.admin-show-detail-page', compact('release'));
  }

  /**
   * Create entity (show UI)
   *
   * @param CreateReleaseRequest $request
   */
  public function create(CreateReleaseRequest $request)
  {
    $release = null;
    return view('release::admin.admin-create-release-page', compact('release'));
  }

  /**
   * Add a new entity
   *
   * @param StoreReleaseRequest $request
   */
  public function store(StoreReleaseRequest $request)
  {
    $requestData = $request->all();
    if ($request->hasfile('images')) {
      foreach ($request->file('images') as $key => $file) {
        $name = time() . rand(1, 100) . '.' . $file->getClientOriginalName();
        $path = storage_path('app/public/images-release');

        $image = new \Imagick($file->getRealPath());
        // resize image
        $image->resizeImage(400, 400, \Imagick::FILTER_LANCZOS, 1);

        // save image
        $image->writeImage($path . '/' . $name);

        $requestData['images'][$key] = '/storage/images-release/' . $name;
      }
    }

    try {
      $release = Apiato::call('Release@CreateReleaseAction', [new DataTransporter($requestData)]);
    } catch (\Exception $e) {
      return redirect()->route('web_release_create')->with('error', '<p>Release <strong>' . $requestData['name'] . '</strong> Created Failed</p>');
    }
    
    return redirect()->route('web_release_create')->with('success', '<p>Release <strong>' . $release->name . '</strong> Created Successfully</p>');
  }

  /**
   * Edit entity (show UI)
   *
   * @param EditReleaseRequest $request
   */
  public function edit(EditReleaseRequest $request)
  {
    $release = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    return view('release::admin.admin-create-release-page', compact('release'));
  }

  /**
   * Update a given entity
   *
   * @param UpdateReleaseRequest $request
   */
  public function update(UpdateReleaseRequest $request)
  {
    $result      = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    $requestData = $request->all();

    // remove imgages have in result->images but not in request->images_old
    if ($result->images != null && $request->images_old != null) {
      foreach ($result->images as $key => $value) {
        if (!in_array($value, $request->images_old)) {
          $path = storage_path('app/public/images-release');
          unlink($path . substr($value, 23));
        }
      }
    } else if ($result->images != null && $request->images_old == null) {
      foreach ($result->images as $key => $value) {
        $path = storage_path('app/public/images-release');
        unlink($path . substr($value, 23));
      }
    }

    if ($request->images_old != null) {
      foreach ($request->images_old as $key => $value) {
        $requestData['images'][$key] = $value;
      }
    } else {
      $requestData['images'] = [];
    }
    if ($request->hasfile('images')) {
      foreach ($request->file('images') as $file) {
        $name = time() . rand(1, 100) . '.' . $file->getClientOriginalName();
        $path = storage_path('app/public/images-release');

        $image = new \Imagick($file->getRealPath());
        // resize image
        $image->resizeImage(400, 400, \Imagick::FILTER_LANCZOS, 1);

        // save image
        $image->writeImage($path . '/' . $name);

        $requestData['images'][] = '/storage/images-release/' . $name;
      }
    }

    // dd($requestData['images']);

    $release = Apiato::call('Release@UpdateReleaseAction', [new DataTransporter($requestData)]);

    return redirect()->route('web_release_edit', [$release->id])->with('success', '<p>Release <strong>' . $release->name . '</strong> Updated Successfully</p>');
  }

  /**
   * Delete a given entity
   *
   * @param DeleteReleaseRequest $request
   */
  public function delete(DeleteReleaseRequest $request)
  {
    $result = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    if ($result == null) {
      return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release Not Found </p>');
    }
    try {
      Apiato::call('Release@DeleteReleaseAction', [new DataTransporter($request)]);
      if ($result->images != null) {
        foreach ($result->images as $value) {
          $path = storage_path('app/public/images-release');
          unlink($path . substr($value, 23));
        }
      }
    } catch (\Exception $e) {
      return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release Not Found </p>');
    }
    return redirect()->route('web_release_get_all_release')->with('success', '<p style="color:blue">Release <strong>' . $result->name . '</strong> Deleted Successfully</p>');
  }
  public function deleteBulk(DeleteBulkReleaseRequest $request)
  {
    $result = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    if ($result == null) {
      return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release(s) Not Found </p>');
    } else {
      $releaseName = '';
      foreach ($result as $value) {
        $releaseName .= $value->name . ', ';
      }
      $releaseName = substr($releaseName, 0, -2);
    }
    try {
      Apiato::call('Release@DeleteBulkReleaseAction', [new DataTransporter($request)]);
      foreach ($result as $item) {
        if ($item->images != null) {
          foreach ($item->images as $image) {
            $path = storage_path('app/public/images-release');
            unlink($path . substr($image, 23));
          }
        }
      }
    } catch (\Exception $e) {
      return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release(s) Not Found </p>');
    }
    return redirect()->route('web_release_get_all_release')->with('success', '<p style="color:blue"> Release <strong>' . $releaseName . '</strong> Deleted Successfully </p>');
  }

  public function search(SearchReleaseRequest $request)
  {
    $releases = Apiato::call('Release@SearchReleaseAction', [new DataTransporter($request)]);
    return $releases;
  }

  public function searchById(SearchReleaseRequest $request)
  {
    $releases = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    return [$releases];
  }

  public function searchByDate(SearchReleaseRequest $request)
  {
    $releases = Apiato::call('Release@SearchReleaseByDateAction', [new DataTransporter($request)]);
    return $releases;

  }
}