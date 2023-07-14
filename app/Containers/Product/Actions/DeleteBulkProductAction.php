<?php

namespace App\Containers\Product\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Transporters\DataTransporter;
use Apiato\Core\Foundation\Facades\Apiato;

class DeleteBulkProductAction extends Action
{
  public function run(DataTransporter $request)
  {
    $product_Ids = [];
    foreach ($request->ids as $id) {
      $product = Apiato::call('User@FindProductByIdTask', [$id]);
      array_push($product_Ids, $product->id);
    }
    return Apiato::call('User@DeleteProductTask', [$product_Ids]);
  }
}