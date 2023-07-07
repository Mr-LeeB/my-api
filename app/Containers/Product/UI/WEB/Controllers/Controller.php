<?php

namespace App\Containers\Product\UI\WEB\Controllers;

use App\Containers\Product\UI\WEB\Requests\CreateProductRequest;
use App\Containers\Product\UI\WEB\Requests\DeleteProductRequest;
use App\Containers\Product\UI\WEB\Requests\GetAllProductsRequest;
use App\Containers\Product\UI\WEB\Requests\FindProductByIdRequest;
use App\Containers\Product\UI\WEB\Requests\UpdateProductRequest;
use App\Containers\Product\UI\WEB\Requests\StoreProductRequest;
use App\Containers\Product\UI\WEB\Requests\EditProductRequest;
use App\Ship\Parents\Controllers\WebController;
use Apiato\Core\Foundation\Facades\Apiato;

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
    public function index(GetAllProductsRequest $request)
    {
        $products = Apiato::call('Product@GetAllProductsAction', [$request]);

        // ..
    }

    /**
     * Show one entity
     *
     * @param FindProductByIdRequest $request
     */
    public function show(FindProductByIdRequest $request)
    {
        $product = Apiato::call('Product@FindProductByIdAction', [$request]);

        // ..
    }

    /**
     * Create entity (show UI)
     *
     * @param CreateProductRequest $request
     */
    public function create(CreateProductRequest $request)
    {
        // ..
    }

    /**
     * Add a new entity
     *
     * @param StoreProductRequest $request
     */
    public function store(StoreProductRequest $request)
    {
        $product = Apiato::call('Product@CreateProductAction', [$request]);

        // ..
    }

    /**
     * Edit entity (show UI)
     *
     * @param EditProductRequest $request
     */
    public function edit(EditProductRequest $request)
    {
        $product = Apiato::call('Product@GetProductByIdAction', [$request]);

        // ..
    }

    /**
     * Update a given entity
     *
     * @param UpdateProductRequest $request
     */
    public function update(UpdateProductRequest $request)
    {
        $product = Apiato::call('Product@UpdateProductAction', [$request]);

        // ..
    }

    /**
     * Delete a given entity
     *
     * @param DeleteProductRequest $request
     */
    public function delete(DeleteProductRequest $request)
    {
         $result = Apiato::call('Product@DeleteProductAction', [$request]);

         // ..
    }
}
