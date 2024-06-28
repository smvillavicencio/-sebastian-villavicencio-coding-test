<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $data = $this->productService->all();
            return response($data, 200);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response("Server error", 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'product_name' => ['required', 'max:255'],
                'product_description' => 'required',
                'product_price' => ['required', 'numeric', 'gte:0', 'decimal:0,2']
            ]);

            $product = $this->productService->add($data);

            return response($product->product_name . " successfully added to the database.", 200);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response("Server error", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->productService->find($id);

            return response($data, 200);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response("Server error", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'product_name' => ['required', 'max:255'],
                'product_description' => 'required',
                'product_price' => ['required', 'numeric', 'gte:0', 'decimal:0,2']
            ]);

            $data = $this->productService->update($validated, $id);

            if ($data) {
                return response("Product with product id " . $id . " was successfully edited", 200);
            } else {
                return response("Product with product id " . $id . " not found.", 404);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response("Server error", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->productService->delete($id);
            if ($data) {
                return response("Product with product id " . $id . " was successfully deleted", 200);
            } else {
                return response("Product with product id " . $id . " not found.", 404);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return response("Server error", 500);
        }
    }
}
