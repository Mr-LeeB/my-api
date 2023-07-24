<?php

namespace App\Containers\User\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;

use App\Containers\User\UI\WEB\Requests\CheckPasswordRequests;
use App\Containers\User\UI\WEB\Requests\CreateNewUserRequests;
use App\Containers\User\UI\WEB\Requests\DeleteMoreUsersRequests;
use App\Containers\User\UI\WEB\Requests\DeleteUserRequests;
use App\Containers\User\UI\WEB\Requests\FindUserByIdRequests;
use App\Containers\User\UI\WEB\Requests\GetAllUserRequests;
use App\Containers\User\UI\WEB\Requests\RegisterUserRequests;
use App\Containers\User\UI\WEB\Requests\UpdateUserRequests;

use App\Containers\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\Authorization\UI\API\Requests\GetAllRolesRequest;
use App\Containers\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;

use App\Containers\User\UI\WEB\Requests\UserRemoveAccountRequests;
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
  public function getAllUser(GetAllUserRequests $request, FindUserByIdRequests $findUserRequest)
  { // admin show all user
    $users = Apiato::call('User@GetAllUsersAction', [new DataTransporter($request)]);

    $roles = self::getAllRole(new GetAllRolesRequest());

    $isEdited = -1;
    $userEdited = null;

    if ($findUserRequest->id) {
      $findUserRequest->validate(
        [
          'id' => 'required|exists:users,id',
        ]
      );
      $isEdited = $findUserRequest->id;
      $userEdited = self::findUserById($findUserRequest);
    }
    return view('user::home', compact('users', 'isEdited', 'userEdited', 'roles'));
  }

  private function getAllRole(GetAllRolesRequest $request)
  {
    $roles = Apiato::call('Authorization@GetAllRolesAction', [new DataTransporter($request)]);
    return $roles;
  }

  private function findUserById(FindUserByIdRequests $request)
  {
    $user = Apiato::call('User@FindUserByIdAction', [new DataTransporter($request)]);
    return $user;
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function updateUser(UpdateUserRequests $request)
  { // admin update user
    $result = Apiato::call('User@UpdateUserAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('message', "Update user successfully");
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function createUser(CreateNewUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('createSuccess', "Create user successfully");
  }

  /**
   * @return
   */
  public function deleteUser(DeleteUserRequests $request)
  { // admin delete user
    // $authUser = $request->id;
    try {
      $result = Apiato::call('User@DeleteUserAction', [new DataTransporter($request)]);

      // if (Auth::user()->id == $authUser) {
      //   Apiato::call('Authentication@WebLogoutAction');
      //   return redirect('logout')->with($result);
      // }
      return redirect()->route('get_all_user')->with('message', "Delete user successfully");
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

  public function removeUserAccount(UserRemoveAccountRequests $request)
  { // user remove account
    $authUser = $request->id;
    try {
      $result = Apiato::call('User@DeleteUserAction', [new DataTransporter($request)]);

      if (Auth::user()->id == $authUser) {
        Apiato::call('Authentication@WebLogoutAction');
        return redirect('logout')->with($result);
      }
      return redirect()->route('get_all_user')->with('message', "Delete user successfully");
    } catch (Exception $e) {
      return redirect('listuser')->with('users', $e);
    }
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function registerUser(RegisterUserRequests $request)
  { // admin create user
    // Log::info($request);
    $result = Apiato::call('User@RegisterUserAction', [new DataTransporter($request)]);

    return redirect('login')->with($result);
  }

  /**
   * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function assignUserToRole(AssignUserToRoleRequest $request)
  { // admin assign role to user
    $result = Apiato::call('Authorization@AssignUserToRoleAction', [new DataTransporter($request)]);
    return redirect('listuser')->with('success', true);
  }

  public function revokeUserFromRole(RevokeUserFromRoleRequest $request)
  { // admin revoke role from user
    $result = Apiato::call('Authorization@RevokeUserFromRoleAction', [new DataTransporter($request)]);
    return ($result);
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
