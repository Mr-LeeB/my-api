<?php

namespace App\Containers\Authentication\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Containers\Authentication\UI\WEB\Requests\ViewDashboardRequest;
use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
use Exception;
use Log;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class LoginController extends WebController
{
  public function loginUser(LoginRequest $request)
  {
    // dd('hi login');
    try {
      $result = Apiato::call('Authentication@WebLoginAction', [new DataTransporter($request)]);
    } catch (Exception $e) {
      // dd($e);
      return redirect('login')->with('status', $e->getMessage());
    }

    return is_array($result) ? redirect('login')->with($result) : redirect('dashboard');
  }

  public function showUserLoginPage()
  {
    return view('authentication::userlogin');
  }
}
