<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

class DeleteBulkReleaseVueJSAction extends Action
{
    public function run(DataTransporter $request)
    {
        // $release_Ids = [];
        // $release     = Apiato::call('Release@FindReleaseByIdTask', [$request->id]);

        // foreach ($release as $Rid) {
        //     array_push($release_Ids, $Rid->id);
        // }
        return Apiato::call('Release@DeleteBulkReleaseVueJSTask', [$request->id]);
    }
}