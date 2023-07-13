<?php

namespace App\Containers\Product\UI\WEB\Controllers;

use App\Containers\Product\UI\WEB\Requests\CreateProductRequest;
use App\Containers\Product\UI\WEB\Requests\DeleteProductRequest;
use App\Containers\Product\UI\WEB\Requests\GetAllProductsRequest;
use App\Containers\Product\UI\WEB\Requests\FindProductByIdRequest;
use App\Containers\Product\UI\WEB\Requests\UpdateProductRequest;
use App\Ship\Parents\Controllers\WebController;
use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Transporters\DataTransporter;
use Image;

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
    dd("findProductById");
    $product = Apiato::call('Product@FindProductByIdAction', [new DataTransporter($request)]);

    // ..
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

    // $image = Image::make($request->file('image')->getRealPath());
    // $image->resize(100, 100)->save($path . '/' . $fileName);

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

    dd("updateProduct");
    $product = Apiato::call('Product@UpdateProductAction', [new DataTransporter($request)]);

    // ..
  }

  /**
   * Delete a given entity
   *
   * @param DeleteProductRequest $request
   */
  public function deleteProduct(DeleteProductRequest $request)
  {
    $result = Apiato::call('Product@DeleteProductAction', [new DataTransporter($request)]);

    // ..
  }

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function showCreateProductPage()
  {
    $product = null;
    return view('product::create-product-page', compact('product'));
  }
}