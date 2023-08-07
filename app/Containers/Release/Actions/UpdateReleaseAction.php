<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class UpdateReleaseAction extends Action
{
  public function run(DataTransporter $request)
  {
    $data = [
      'name' => $request->name,
      'date_created' => $request->date_created,
      'title_description' => $request->title_description,
      'detail_description' => $request->detail_description,
      'is_publish' => $request->is_publish ? true : false,
      'images' => $request->images,
    ];

    // remove null values and their keys but keep 0 values
    $data = array_filter($data, function ($value) {
      return $value !== null;
    });

    $release = Apiato::call('Release@UpdateReleaseTask', [$request->id, $data]);

    return $release;
  }
}