<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class UpdateReleaseAction extends Action
{
  public function run(DataTransporter $request)
  {
    $data = $request->sanitizeInput([
      'name',
      'date_created',
      'title_description',
      'detail_description',
      'is_publish',
      'images'
    ]);

    // remove null values and their keys
    $data = array_filter($data);

    $release = Apiato::call('Release@UpdateReleaseTask', [$request->id, $data]);

    return $release;
  }
}