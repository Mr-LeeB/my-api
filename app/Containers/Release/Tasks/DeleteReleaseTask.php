<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteReleaseTask extends Task
{

    protected $repository;

    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {
            return $this->repository->delete($id);
            // return $this->repository->whereIn('id', $id)->delete();
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}