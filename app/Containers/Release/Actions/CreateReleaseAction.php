<?php

namespace App\Containers\Release\Actions;

use App\Containers\Release\Models\Release;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class CreateReleaseAction extends Action
{
  public function run(DataTransporter $data): Release
  {

  $release = Apiato::call('Release@CreateReleaseTask', [
      $data->name,
      $data->date_created,
      $data->title_description,
      $data->detail_description,
      $data->is_publish ?? false,
      $data->images ?? null,
    ]);

    return $release;
  }
}