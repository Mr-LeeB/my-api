<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class SearchReleaseByDateTask extends Task
{

    protected $repository;

    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($date)
    {
        try {
            return $this->repository->where('created_at', '=', $date)->get();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}