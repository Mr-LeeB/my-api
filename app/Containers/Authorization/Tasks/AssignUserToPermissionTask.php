<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Log;

/**
 * Class AssignUserToRoleTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class AssignUserToPermissionTask extends Task
{

  /**
   * @param \App\Containers\User\Models\User $user
   * @param array                            $permissions
   *
   * @return  \Illuminate\Contracts\Auth\Authenticatable
   */
  public function run(User $user, array $permissions): Authenticatable
  {
    // dd($user, $permissions);
    $user->givePermissionTo($permissions);
    return $user;
  }
}
