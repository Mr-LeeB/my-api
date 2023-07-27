<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class UpdateReleaseAction extends Action
{
  public function run(Request $request)
  {
    $data = $request->sanitizeInput([
      'name',
      'date_created',
      'title_description',
      'detail_description',
      'is_publish'
    ]);

    // remove null values and their keys
    $data = array_filter($data);

    $release = Apiato::call('Release@pUpdateReleaseTask', [$request->id, $data]);

    return $release;
  }
}