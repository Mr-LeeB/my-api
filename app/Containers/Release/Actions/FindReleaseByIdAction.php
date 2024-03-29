<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class FindReleaseByIdAction extends Action
{
  public function run(DataTransporter $request)
  {
    $release = Apiato::call('Release@FindReleaseByIdTask', [$request->id]);

    return $release;
  }
}
