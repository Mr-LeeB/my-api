<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;

/**
 * Class AssignUserToRoleAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AssignUserToPermissionAction extends Action
{

  /**
   * @param \App\Ship\Transporters\DataTransporter $data
   *
   * @return  \App\Containers\User\Models\User
   */
  public function run(DataTransporter $data): User
  {
    $user = Apiato::call('User@FindUserByIdTask', [$data->user_id]);

    // convert to array in case single ID was passed
    $permissionsIds = (array) $data->permissions_ids;

    $permissions = array_map(function ($permissionId) {
      return Apiato::call('Authorization@FindPermissionTask', [$permissionId]);
    }, $permissionsIds);
    // dd($permissions);

    $user = Apiato::call('Authorization@AssignUserToPermissionTask', [$user, $permissions]);

    return $user;
  }
}
