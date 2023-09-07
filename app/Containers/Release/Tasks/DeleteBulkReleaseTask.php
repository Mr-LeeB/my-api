<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteBulkReleaseTask extends Task
{

    protected $repository;

    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($release_Ids)
    {
        try {
            return $this->repository->whereIn('id', $release_Ids)->delete();

        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}