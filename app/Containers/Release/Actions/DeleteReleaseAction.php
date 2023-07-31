<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class DeleteReleaseAction extends Action
{
  public function run(DataTransporter $request)
  {
    return Apiato::call('Release@DeleteReleaseTask', [$request->id]);
  }
}