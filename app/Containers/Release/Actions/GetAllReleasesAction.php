<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class GetAllReleasesAction extends Action
{
  public function run(DataTransporter $request)
  {
    $releases = Apiato::call('Release@GetAllReleasesTask', [], ['addRequestCriteria', 'ordered']);

    return $releases;
  }
}