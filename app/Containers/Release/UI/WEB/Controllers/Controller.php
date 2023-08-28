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
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Storage;
use Exception;

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
        // dd($releases);

        $all_Releases_count = Release::all()->count();

        // if (auth()->user()->hasAdminRole()) {
        return view('release::admin.admin-show-release-page', compact('releases', 'all_Releases_count'));
        // }
        // return new Exception('You are not authorized to access this page');
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
        // dd($request->file('images'));
        $requestData = $request->all();
        if ($request->hasfile('images')) {
            foreach ($request->images as $key => $file) {
                $name = time() . rand(1, 100) . '.' . $file->getClientOriginalName();

                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(400, 400);
                $image_resize->save(public_path('storage/images/' . $name));

                $saved_image_uri = $image_resize->dirname . '/' . $name;

                Storage::disk('public')->putFileAs('images-release', new File($saved_image_uri), $name, 'public');

                $image_resize->destroy();
                unlink($saved_image_uri);
                // Storage::disk('public')->putFileAs('images-release', $image_resize, $name, 'public');
                // $file->storeAs('public/images-release', $name);
                $requestData['images'][$key] = '/storage/images-release/' . $name;
            }
        }

        try {
            $release = Apiato::call('Release@CreateReleaseAction', [new DataTransporter($requestData)]);
        } catch (Exception $e) {
            \Log::error($e);
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
        try {
            $result = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_release_edit', [$request->id])->with('error', '<p>Release <strong>' . $request->name . '</strong> Updated Failed</p>');
        }

        $requestData = $request->all();

        if ($result->images) {
            if ($request->images_old) {
                foreach ($result->images as $key => $value) {
                    if (!in_array($value, $request->images_old)) {
                        Storage::disk('public')->delete(substr($value, 8));
                    }
                }
                $requestData['images'] = $request->images_old;
            } else {
                foreach ($result->images as $key => $value) {
                    Storage::disk('public')->delete(substr($value, 8));
                }
                $requestData['images'] = [];
            }
        } else {
            $requestData['images'] = [];
        }

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . rand(1, 100) . '.' . $file->getClientOriginalName();

                $image_resize = Image::make($file->getRealPath());
                $image_resize->resize(400, 400);
                $image_resize->save(public_path('storage/images/' . $name));

                $saved_image_uri = $image_resize->dirname . '/' . $name;

                Storage::disk('public')->putFileAs('images-release', new File($saved_image_uri), $name, 'public');

                $image_resize->destroy();
                unlink($saved_image_uri);

                // Storage::disk('public')->putFileAs('images-release', $file, $name, 'public');

                $requestData['images'][] = '/storage/images-release/' . $name;
            }
        }

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
        try {
            $result = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);

            Apiato::call('Release@DeleteReleaseAction', [new DataTransporter($request)]);
            if ($result->images != null) {
                foreach ($result->images as $value) {
                    Storage::disk('public')->delete(substr($value, 8));
                }
            }
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release Not Found </p>');
        }
        return redirect()->route('web_release_get_all_release')->with('success', '<p style="color:blue">Release <strong>' . $result->name . '</strong> Deleted Successfully</p>');
    }
    public function deleteBulk(DeleteBulkReleaseRequest $request)
    {

        try {
            $result = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_release_get_all_release')->with('error', '<p style="color:red"> Release(s) Not Found </p>');
        }

        $releaseName = '';
        foreach ($result as $value) {
            $releaseName .= $value->name . ', ';
        }
        $releaseName = substr($releaseName, 0, -2);

        try {
            Apiato::call('Release@DeleteBulkReleaseAction', [new DataTransporter($request)]);
            foreach ($result as $item) {
                if ($item->images != null) {
                    foreach ($item->images as $image) {
                        Storage::disk('public')->delete(substr($image, 8));
                    }
                }
            }
        } catch (Exception $e) {
            \Log::error($e);
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