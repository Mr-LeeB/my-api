<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class GetAllRolesAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllRolesAction extends Action
{

  /**
   * @return mixed
   */
  public function run()
  {
    $skipPagination = true;
    $roles          = Apiato::call('Authorization@GetAllRolesTask', [$skipPagination], ['addRequestCriteria']);

    return $roles;
  }

}