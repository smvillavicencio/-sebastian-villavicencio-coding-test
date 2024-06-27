<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $data = Product::paginate(10);
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
            $this->validate($request, [
                'product_name' => ['required', 'max:255'],
                'product_description' => 'required',
                'product_price' => ['required', 'numeric', 'gte:0', 'decimal:0,2']
            ]);

            $product = new Product;
            $product->product_name = $request->product_name;
            $product->product_description = $request->product_description;
            $product->product_price = $request->product_price;
            $product->save();

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
            // Store a product in the cache for 10 minutes
            $data = Cache::remember('product_' . $id, 60 * 10, function () use ($id) {
                return Product::where('id', $id)->get();
            });
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

            $data = Product::where('id', $id)->update($validated);

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
            $data = Product::where('id', '=', $id)->delete();
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
