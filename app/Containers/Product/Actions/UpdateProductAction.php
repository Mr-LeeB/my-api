<?php

namespace App\Containers\Product\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;
use Apiato\Core\Foundation\Facades\Apiato;

class UpdateProductAction extends Action
{
  public function run(DataTransporter $request)
  {
    $data = $request->sanitizeInput([
      'name',
      'description',
      'image'
    ]);

    $product = Apiato::call('Product@UpdateProductTask', [$request->id, $data]);

    return $product;
  }
}