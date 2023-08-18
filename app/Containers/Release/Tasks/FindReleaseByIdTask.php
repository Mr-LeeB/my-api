<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindReleaseByIdTask extends Task
{

  protected $repository;

  public function __construct(ReleaseRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($id)
  {
    try {
      return $this->repository->find($id);
    } catch (Exception $exception) {
      throw new NotFoundException();
    }
  }
}