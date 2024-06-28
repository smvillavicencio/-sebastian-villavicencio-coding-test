<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
	public function all()
	{
		return Product::paginate(10);
	}

	public function add(array $data)
	{
		$product = new Product;
		$product->product_name = $data['product_name'];
		$product->product_description = $data['product_description'];
		$product->product_price = $data['product_price'];
		$product->save();

		return $product;
	}

	public function update(array $data, $id)
	{
		return Product::where('id', $id)->update($data);
	}

	public function delete($id)
	{
		return Product::where('id', '=', $id)->delete();
	}
	public function find($id)
	{
		// Store a product in the cache for 10 minutes
		return Cache::remember('product_' . $id, 60 * 10, function () use ($id) {
			return Product::where('id', $id)->get();
		});
	}

}
