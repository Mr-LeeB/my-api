<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Containers\Authorization\Models\Role;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class CreateRoleTask.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateRoleTask extends Task
{

  /**
   * @var  \App\Containers\Authorization\Data\Repositories\RoleRepository
   */
  protected $repository;

  /**
   * CreateRoleTask constructor.
   *
   * @param \App\Containers\Authorization\Data\Repositories\RoleRepository $repository
   */
  public function __construct(RoleRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @param string      $name
   * @param string|null $description
   * @param string|null $displayName
   * @param int         $level
   *
   * @return Role
   * @throws UpdateResourceFailedException
   */
  public function run($id, array $data): Role
  {
    app()['cache']->forget('spatie.permission.cache');

    try {
      $role = $this->repository->update($data, $id);
    } catch (Exception $exception) {
      throw new UpdateResourceFailedException();
    }

    return $role;
  }

}