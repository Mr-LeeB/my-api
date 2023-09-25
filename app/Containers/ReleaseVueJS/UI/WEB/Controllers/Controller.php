<?php

namespace App\Containers\ReleaseVueJS\UI\WEB\Controllers;

use App\Containers\ReleaseVueJS\Models\ReleaseVueJS;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\CreateReleaseVueJSRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\DeleteBulkReleaseVueJSRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\DeleteReleaseVueJSRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\GetAllReleaseVueJsRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\FindReleaseVueJSByIdRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\UpdateReleaseVueJSRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\StoreReleaseVueJSRequest;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\EditReleaseVueJSRequest;

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
     * @param GetAllReleaseVueJsRequest $request
     */
    public function getAllRelease(GetAllReleaseVueJsRequest $request)
    {
        $releases           = Apiato::call('ReleaseVueJS@GetAllReleaseVueJsAction', [new DataTransporter($request)]);
        $all_Releases_count = ReleaseVueJS::all()->count();

        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'status' => 'success',
        //         'data'   => $releases,
        //         'meta'   => [
        //             'total' => $all_Releases_count,
        //         ],
        //     ]);
        // }

        return view('releasevuejs::admin.admin-show-release-page', compact('releases', 'all_Releases_count'));
    }

    /**
     * Show one entity
     *
     * @param FindReleaseVueJSByIdRequest $request
     */
    public function showDetailRelease(FindReleaseVueJSByIdRequest $request)
    {
        $release = Apiato::call('ReleaseVueJS@FindReleaseVueJSByIdAction', [new DataTransporter($request)]);

        return view('releasevuejs::admin.admin-show-detail-page', compact('release'));
    }

    /**
     * Create entity (show UI)
     *
     * @param CreateReleaseVueJSRequest $request
     */
    public function create(CreateReleaseVueJSRequest $request)
    {
        $release = null;
        return view('releasevuejs::admin.admin-create-release-page', compact('release'));
    }

    /**
     * Add a new entity
     *
     * @param StoreReleaseVueJSRequest $request
     */
    public function store(StoreReleaseVueJSRequest $request)
    {
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
                $requestData['images'][$key] = '/storage/images-release/' . $name;
            }
        }

        try {
            $release = Apiato::call('ReleaseVueJS@CreateReleaseVueJSAction', [new DataTransporter($requestData)]);
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_releasevuejs_create')->with('error', '<p>Release <strong>' . $requestData['name'] . '</strong> Created Failed</p>');
        }

        return redirect()->route('web_releasevuejs_create')->with('success', '<p>Release <strong>' . $release->name . '</strong> Created Successfully</p>');
    }

    /**
     * Edit entity (show UI)
     *
     * @param EditReleaseVueJSRequest $request
     */
    public function edit(EditReleaseVueJSRequest $request)
    {
        $release = Apiato::call('ReleaseVueJS@FindReleaseVueJSByIdAction', [new DataTransporter($request)]);
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'data'   => $release,
            ]);
        }
        return view('releasevuejs::admin.admin-create-release-page', compact('release'));
    }

    /**
     * Update a given entity
     *
     * @param UpdateReleaseVueJSRequest $request
     */
    public function update(UpdateReleaseVueJSRequest $request)
    {
        try {
            $result = Apiato::call('ReleaseVueJS@FindReleaseVueJSByIdAction', [new DataTransporter($request)]);
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_releasevuejs_edit', [$request->id])->with('error', '<p>Release <strong>' . $request->name . '</strong> Updated Failed</p>');
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

        $release = Apiato::call('ReleaseVueJS@UpdateReleaseVueJSAction', [new DataTransporter($requestData)]);

        return redirect()->route('web_releasevuejs_edit', [$release->id])->with('success', '<p>Release <strong>' . $release->name . '</strong> Updated Successfully</p>');
    }

    /**
     * Delete a given entity
     *
     * @param DeleteReleaseVueJSRequest $request
     */
    public function delete(DeleteReleaseVueJSRequest $request)
    {
        try {
            $result = Apiato::call('ReleaseVueJS@FindReleaseVueJSByIdAction', [new DataTransporter($request)]);

            Apiato::call('ReleaseVueJS@DeleteReleaseVueJSAction', [new DataTransporter($request)]);
            if ($result->images != null) {
                foreach ($result->images as $value) {
                    Storage::disk('public')->delete(substr($value, 8));
                }
            }
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_releasevuejs_get_all_release')->with('error', '<p style="color:red"> Release Not Found </p>');
        }
        return redirect()->route('web_releasevuejs_get_all_release')->with('success', '<p style="color:blue">Release <strong>' . $result->name . '</strong> Deleted Successfully</p>');
    }
    public function deleteBulk(DeleteBulkReleaseVueJSRequest $request)
    {

        try {
            $result = Apiato::call('ReleaseVueJS@FindReleaseVueJSByIdAction', [new DataTransporter($request)]);
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_releasevuejs_get_all_release')->with('error', '<p style="color:red"> Release(s) Not Found </p>');
        }

        $releaseName = '';
        foreach ($result as $value) {
            $releaseName .= $value->name . ', ';
        }
        $releaseName = substr($releaseName, 0, -2);

        try {
            Apiato::call('ReleaseVueJS@DeleteBulkReleaseVueJSAction', [new DataTransporter($request)]);
            foreach ($result as $item) {
                if ($item->images != null) {
                    foreach ($item->images as $image) {
                        Storage::disk('public')->delete(substr($image, 8));
                    }
                }
            }
        } catch (Exception $e) {
            \Log::error($e);
            return redirect()->route('web_releasevuejs_get_all_release')->with('error', '<p style="color:red"> Release(s) Not Found </p>');
        }
        return redirect()->route('web_releasevuejs_get_all_release')->with('success', '<p style="color:blue"> Release <strong>' . $releaseName . '</strong> Deleted Successfully </p>');
    }

    // public function search(SearchReleaseRequest $request)
    // {
    //     $releases = Apiato::call('Release@SearchReleaseAction', [new DataTransporter($request)]);
    //     return $releases;
    // }

    // public function searchById(SearchReleaseRequest $request)
    // {
    //     $releases = Apiato::call('Release@FindReleaseByIdAction', [new DataTransporter($request)]);
    //     return [$releases];
    // }

    // public function searchByDate(SearchReleaseRequest $request)
    // {
    //     $releases = Apiato::call('Release@SearchReleaseByDateAction', [new DataTransporter($request)]);
    //     return $releases;

    // }
}