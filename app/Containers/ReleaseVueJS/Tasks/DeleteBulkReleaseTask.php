<?php

namespace App\Containers\Release\Tasks;

use App\Containers\ReleaseVueJS\Data\Repositories\ReleaseVueJSRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteBulkReleaseVueJSTask extends Task
{

    protected $repository;

    public function __construct(ReleaseVueJSRepository $repository)
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