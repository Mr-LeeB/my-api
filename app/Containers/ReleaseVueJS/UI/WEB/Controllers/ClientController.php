<?php

namespace App\Containers\ReleaseVueJS\UI\WEB\Controllers;

use App\Containers\ReleaseVueJS\Actions\GetAllReleaseVueJsAction;

use App\Containers\ReleaseVueJS\UI\WEB\Requests\GetAllReleaseVueJsRequest;

use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Support\Facades\App;

/**
 * Class Controller
 *
 * @package App\Containers\Release\UI\WEB\Controllers
 */
class ClientController extends WebController
{
    public function showTest(GetAllReleaseVueJsRequest $request)
    {
        $releases = App::make(GetAllReleaseVueJsAction::class)->run(new DataTransporter($request->all()));

        return view('releasevuejs::client.test-page', compact('releases'));
    }

}