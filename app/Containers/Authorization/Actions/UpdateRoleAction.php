<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\Models\Role;
use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;
use function is_null;

/**
 * Class CreateRoleAction
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class UpdateRoleAction extends Action
{

  /**
   * @param \App\Ship\Transporters\DataTransporter $data
   *
   * @return  \App\Containers\Authorization\Models\Role
   */
  public function run(DataTransporter $request): Role
  {
    $level = is_null($request->level) ? 0 : $request->level;

    $data = $request->sanitizeInput([
      'name',
      'description',
      'display_name',
      'level'
    ]);

    $role = Apiato::call(
      'Authorization@UpdateRoleTask',
      [
        $request->id,
        $data
      ]
    );

    return $role;
  }
}
