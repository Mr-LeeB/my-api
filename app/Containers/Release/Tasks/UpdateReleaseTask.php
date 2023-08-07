<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Ship\Exceptions\NotFoundException;

class UpdateReleaseTask extends Task
{

  protected $repository;

  public function __construct(ReleaseRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($id, array $data)
  {
    if (empty($data)) {
      throw new UpdateResourceFailedException('Inputs are empty.');
    }
    try {
      return $this->repository->update($data, $id);
    } catch (ModelNotFoundException $exception) {
      throw new NotFoundException('Release Not Found.');
    } catch (Exception $exception) {
      throw new UpdateResourceFailedException();
    }
  }
}