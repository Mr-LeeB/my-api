<?php

namespace App\Containers\Release\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class ReleaseRepository
 */
class ReleaseRepository extends Repository
{

  /**
   * @var array
   */
  protected $fieldSearchable = [
    'id' => '=',
    'name' => 'like',
    'date_created' => '=',
    'title_description' => 'like',
    'detail_description' => 'like',
    'is_publish' => 'like',
    'images' => '',
    // ...
  ];
}