<?php

namespace App\Containers\Product\UI\WEB\Controllers;

use App\Containers\Product\UI\WEB\Requests\CreateProductRequest;
use App\Containers\Product\UI\WEB\Requests\DeleteBulkProductRequest;
use App\Containers\Product\UI\WEB\Requests\DeleteProductRequest;
use App\Containers\Product\UI\WEB\Requests\GetAllProductsRequest;
use App\Containers\Product\UI\WEB\Requests\FindProductByIdRequest;
use App\Containers\Product\UI\WEB\Requests\UpdateProductRequest;
use App\Ship\Parents\Controllers\WebController;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;

/**
 * Class Controller
 *
 * @package App\Containers\Product\UI\WEB\Controllers
 */
class Controller extends WebController
{
  /**
   * Show all entities
   *
   * @param GetAllProductsRequest $request
   */
  public function getAllProducts(GetAllProductsRequest $request)
  {
    $products = Apiato::call('Product@GetAllProductsAction', [new DataTransporter($request)]);

    return view('product::home', compact('products'));
  }

  /**
   * Show one entity
   *
   * @param FindProductByIdRequest $request
   */
  public function findProductById(FindProductByIdRequest $request)
  {
    $product = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

    return view('product::product-detail-page', compact('product'));

  }

  /**
   * Add a new entity
   *
   * @param CreateProductRequest $request
   */
  public function createProduct(CreateProductRequest $request)
  {
    $requestData = $request->all();

    $fileName = time() . $request->file('image')->getClientOriginalName();
    $path = storage_path('app/public/images');

    $image = new \Imagick($request->file('image')->getRealPath());
    // resize image
    $image->resizeImage(100, 100, \Imagick::FILTER_LANCZOS, 1);

    // save image
    $image->writeImage($path . '/' . $fileName);

    $requestData['image'] = '/storage/images/' . $fileName;

    $product = Apiato::call('Product@CreateProductAction', [new DataTransporter($requestData)]);

    return view('product::create-product-page', compact('product'));
  }

  /**
   * Update a given entity
   *
   * @param UpdateProductRequest $request
   */
  public function updateProduct(UpdateProductRequest $request)
  {
    $oldProduct = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

    $requestData = $request->all();
    $fileName = time() . $request->file('image')->getClientOriginalName();
    $path = storage_path('app/public/images');

    $image = new \Imagick($request->file('image')->getRealPath());

    // resize image
    $image->resizeImage(100, 100, \Imagick::FILTER_LANCZOS, 1);

    // save image
    $image->writeImage($path . '/' . $fileName);

    $requestData['image'] = '/storage/images/' . $fileName;

    $product = Apiato::call('Product@UpdateProductAction', [new DataTransporter($requestData)]);

    // remove old image
    $oldImage = substr($oldProduct->image, 15);
    try {
      unlink(storage_path('app/public/images') . $oldImage);
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    return view('product::product-detail-page', compact('product'));
  }

  /**
   * Delete a given entity
   *
   * @param DeleteProductRequest $request
   */
  public function deleteProduct(DeleteProductRequest $request)
  {
    try {

      $result = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

      if ($result) {
        Apiato::call('Product@DeleteProductAction', [new DataTransporter($request)]);

        $oldImage = substr($result->image, 15);
        unlink(storage_path('app/public/images') . $oldImage);
      }
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    return redirect()->route('web_product_get_all_products')->with('message', 'Product (' . $result->name . ') Deleted Successfully!');
  }

  /**
   * @param $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function bulkDeleteProduct(DeleteBulkProductRequest $request)
  {
    try {

      $result = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

      if ($result) {
        Apiato::call('Product@DeleteProductAction', [new DataTransporter($request)]);

        $oldImage = substr($result->image, 15);
        unlink(storage_path('app/public/images') . $oldImage);
      }
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    return redirect()->route('web_product_get_all_products')->with('message', 'Product (' . $result->name . ') Deleted Successfully!');
  }

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showCreateProductPage()
  {
    $product = null;
    return view('product::create-product-page', compact('product'));
  }

  /**
   * @param $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showDetailProductPage(FindProductByIdRequest $request)
  {
    $product = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

    return view('product::product-detail-page', compact('product'));
  }
}