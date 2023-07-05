<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;

/**
 * Class DeleteUserAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteMoreUsersAction extends Action
{

  /**
   * @param \App\Ship\Transporters\DataTransporter $data
   */
  public function run(DataTransporter $data)
  {
    // $user = $data->id ?
    //   Apiato::call(
    //     'User@FindUserByIdTask',
    //     [$data->id]
    //   ) : Apiato::call('Authentication@GetAuthenticatedUserTask');

    // dd($user);
    // return Apiato::call('User@DeleteUserTask', [$user]);
    // dd($data->ids);

    $user_Ids = [];
    foreach ($data->ids as $id) {
      $user = Apiato::call('User@FindUserByIdTask', [$id]);
      array_push($user_Ids, $user->id);
    }
    // dd($users);
    return Apiato::call('User@DeleteMoreUsersTask', [$user_Ids]);
  }
}