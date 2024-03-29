<?php

namespace App\Containers\Release\Tasks;

use App\Containers\Release\Data\Repositories\ReleaseRepository;
use App\Containers\Release\Models\Release;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateReleaseTask extends Task
{

    protected $repository;

    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string      $name
     * @param string|null $title_description
     * @param string|null $detail_description
     * @param bool|false $is_publish
     * @param array|null $images
     * @return  mixed
     * @throws  CreateResourceFailedException
     */
    public function run(
        string $name,
        string $title_description = null,
        string $detail_description = null,
        bool $is_publish = false,
        array $images = null
    ): Release {
        try {
            // create new release
            $release = $this->repository->create([
                'name'               => $name,
                'title_description'  => $title_description,
                'detail_description' => $detail_description,
                'is_publish'         => $is_publish,
                'images'             => $images ?? null,
            ]);

        } catch (Exception $e) {
            throw (new CreateResourceFailedException())->debug($e);
        }
        return $release;
    }
}