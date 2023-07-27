<?php

namespace App\Containers\Release\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class DeleteReleaseAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Release@DeleteReleaseTask', [$request->id]);
    }
}
