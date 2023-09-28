<?php

namespace App\Containers\ReleaseVueJS\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class DeleteBulkReleaseVueJSAction extends Action
{
    public function run(DataTransporter $request)
    {
        return Apiato::call('ReleaseVueJS@DeleteBulkReleaseVueJSTask', [$request->id]);
    }
}