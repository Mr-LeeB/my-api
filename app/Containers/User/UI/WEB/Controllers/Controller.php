<?php

namespace App\Containers\User\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\UI\WEB\Requests\CheckPasswordRequests;
use App\Containers\User\UI\WEB\Requests\CreateNewUserRequests;
use App\Containers\User\UI\WEB\Requests\DeleteMoreUsersRequests;
use App\Containers\User\UI\WEB\Requests\DeleteUserRequests;
use App\Containers\User\UI\WEB\Requests\GetAllUserRequests;
use App\Containers\User\UI\WEB\Requests\RegisterUserRequests;
use App\Containers\User\UI\WEB\Requests\UpdateUserRequests;
use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
use Auth;
use Exception;
use Log;

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
  public function sayWelcome()
  { // user say welcome
    return view('user::user-welcome');
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getAllUser(GetAllUserRequests $request)
  { // admin show all user
    $result = Apiato::call('User@GetAllUsersAction', [new DataTransporter($request)]);
    return view('user::home', ['users' => $result]);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function updateUser(UpdateUserRequests $request)
  { // admin update user
    $result = Apiato::call('User@UpdateUserAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('wasRecentlyCreated', $result->wasRecentlyCreated);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function createUser(CreateNewUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('wasRecentlyCreated', $result->wasRecentlyCreated);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function deleteUser(DeleteUserRequests $request)
  { // admin delete user
    $authUser = $request->id;
    try {
      $result = Apiato::call('User@DeleteUserAction', [new DataTransporter($request)]);

      if (Auth::user()->id == $authUser) {
        Apiato::call('Authentication@WebLogoutAction');
        return redirect('logout')->with($result);
      }
      return redirect('listuser')->with($result);
    } catch (Exception $e) {
      return redirect('listuser')->with('users', $e);
    }
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function deleteMoreUsers(DeleteMoreUsersRequests $request)
  { // admin delete more users
    try {
      $result = Apiato::call('User@DeleteMoreUsersAction', [new DataTransporter($request)]);

      return redirect('listuser')->with(['users' => $result]);
    } catch (Exception $e) {
      return redirect('listuser')->with('users', $e);
    }
  }

  public function registerUser(RegisterUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);

    return ($result) != null ? redirect('login')->with($result) : redirect('register');
  }

  /**
   * @return boolean
   */
  public function checkPassword(CheckPasswordRequests $request)
  { // user check password

    if (password_verify($request->password, Auth::user()->password))
      return true;
    return Auth::user()->password;
  }
  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showUserRegisterPage()
  { // user show user
    return view('user::register');
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showListUserPage()
  { // user show user
    return view('user::home');
  }
}
