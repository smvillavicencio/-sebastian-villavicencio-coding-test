<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

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
            echo $exception;
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
            echo $exception;
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
            $data = Product::get()->where('id', $id);
            return response($data, 200);
        } catch (\Exception $exception) {
            echo $exception;
            return response("Server error", 500);
        }
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     return;
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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
            echo $exception;
            return response("Server error", 500);
        }
    }
}
