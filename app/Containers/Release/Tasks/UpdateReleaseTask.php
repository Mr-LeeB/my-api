<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateReleaseTask extends Task
{

    protected $repository;

    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        try {
            return $this->repository->update($data, $id);
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
