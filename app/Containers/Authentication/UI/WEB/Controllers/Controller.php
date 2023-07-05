<?php

namespace App\Containers\Authentication\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Containers\Authentication\UI\WEB\Requests\ViewDashboardRequest;
use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
use Exception;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Controller extends WebController
{

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showLoginPage()
  {
    return view('authentication::login');
  }

  /**
   * @return  \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function logoutAdmin(LogoutRequest $request)
  {
    Apiato::call('Authentication@WebLogoutAction');

    return redirect('login');
  }

  /**
   * @param \App\Containers\Authentication\UI\WEB\Requests\LoginRequest $request
   *
   * @return  \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function loginAdmin(LoginRequest $request)
  {
    try {
      $result = Apiato::call('Authentication@WebAdminLoginAction', [new DataTransporter($request)]);
    } catch (Exception $e) {
      return redirect('login')->with('status', $e->getMessage());
    }
    return is_array($result) ? redirect('login')->with($result) : redirect('dashboard');
  }

  public function loginUser(LoginRequest $request)
  {
    try {
      $result = Apiato::call('Authentication@WebLoginAction', [new DataTransporter($request)]);
    } catch (Exception $e) {
      return redirect('login')->with('status', $e->getMessage());
    }
    return is_array($result) ? redirect('login')->with($result) : redirect('userdashboard');
  }

  /**
   * @return  \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function logoutUser(LogoutRequest $request)
  {

    // dd($request);
    $result = Apiato::call('Authentication@WebLogoutAction');

    return redirect('logout')->with(['result' => $result]);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showUserLoginPage()
  {
    return view('authentication::userlogin');
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showUserLogoutPage()
  { // user show user
    return view('authentication::userlogout');
  }

  /**
   * @param \App\Containers\Authentication\UI\WEB\Requests\ViewDashboardRequest $request
   *
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function viewDashboardPage(ViewDashboardRequest $request)
  {
    return view('authentication::dashboard');
  }
}