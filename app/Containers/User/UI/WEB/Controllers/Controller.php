<?php

namespace App\Containers\User\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\UI\WEB\Requests\CreateNewUserRequests;
use App\Containers\User\UI\WEB\Requests\DeleteUserRequests;
use App\Containers\User\UI\WEB\Requests\GetAllUserRequests;
use App\Containers\User\UI\WEB\Requests\RegisterUserRequests;
use App\Containers\User\UI\WEB\Requests\UpdateUserRequests;
use App\Ship\Parents\Controllers\WebController;
use App\Ship\Transporters\DataTransporter;
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
    // dd($result);
    return view('user::home', ['users' => $result]);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function updateUser(UpdateUserRequests $request)
  { // admin update user
    // dd($request);
    $result = Apiato::call('User@UpdateUserAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('users', $result);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function createUser(CreateNewUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);
    // return redirect('listuser')->with(['users' => $result]);
    return redirect('listuser')->with('user', $result);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function deleteUser(DeleteUserRequests $request)
  { // admin delete user
    try {
      // dd($request);
      $result = Apiato::call('User@DeleteUserAction', [new DataTransporter($request)]);

      return redirect('listuser')->with(['users' => $result]);

      // return $result;

    } catch (Exception $e) {
      return redirect('listuser')->with('users', $e);
    }
  }

  public function registerUser(RegisterUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);
    // dd($result);
    return redirect('test');
    // return $result;
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
