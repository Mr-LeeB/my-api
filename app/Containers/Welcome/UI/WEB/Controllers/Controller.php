<?php

namespace App\Containers\Welcome\UI\WEB\Controllers;

use App\Containers\ReleaseVueJS\Actions\GetAllReleaseVueJsAction;
use App\Containers\ReleaseVueJS\UI\WEB\Requests\GetAllReleaseVueJsRequest;
use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
use Illuminate\Support\Facades\App;
use Exception;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Controller extends WebController
{

    /**
     * @return  string
     */
    public function sayWelcome()
    {
        // No actions to call. Since there's nothing to do but returning a response.
        return view('welcome::welcome-page');
        // return view('release::admin.list_zns_message');
    }

    /**
     * @return  string
     */
    public function getZnsPage()
    {
        // No actions to call. Since there's nothing to do but returning a response.
        return view('release::admin.list_zns_message');
    }
}