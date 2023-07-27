<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class FindReleaseByIdAction extends Action
{
    public function run(Request $request)
    {
        $release = Apiato::call('Release@FindReleaseByIdTask', [$request->id]);

        return $release;
    }
}
