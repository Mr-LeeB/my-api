<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class SearchReleaseByDateAction extends Action
{
  public function run(DataTransporter $request)
  {
    $release = Apiato::call('Release@SearchReleaseByDateTask', [$request->date_created]);

    return $release;
  }
}