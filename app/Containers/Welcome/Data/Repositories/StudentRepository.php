<?php

namespace App\Containers\Welcome\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class StudentRepository
 */
class StudentRepository extends Repository
{

  /**
   * @var array
   */
  protected $fieldSearchable = [
    'id' => '=',
    'name' => 'like',
    'content' => 'like',
    // ...
  ];

}