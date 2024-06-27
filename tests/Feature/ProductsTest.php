<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    public function test_api_retrieve_products_list()
    {
        // Create 15 dummy products
        $product = Product::factory()->count(15)->create();

        //  GET the first page of the products list
        $response = $this->getJson(uri: '/api/products?page=1');

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert the structure of the paginated response
        $response->assertJsonStructure([
            'data',
            'current_page',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

        $expectedDataInPage = 10;

        // Assert the number of products returned in the 'data' key
        $response->assertJsonCount($expectedDataInPage, 'data');

    }

    public function test_api_retrieve_single_product()
    {
        // Create 1 product in the test database
        $product = Product::factory()->create();

        // Retrieve the data of the single product
        $response = $this->getJson('/api/products/' . $product->id);

        // Assert that the response status is 200
        $response->assertStatus(200);
        $response->dump();

        // Assert that certain parts of the JSON response contain the specific values
        $response->assertJsonFragment([
            'id' => $product->id,
            'product_name' => $product->product_name,
            'product_description' => $product->product_description,
            'product_price' => $product->product_price,
            'created_at' => $product->created_at->toJSON(),
            'updated_at' => $product->updated_at->toJSON()
        ]);
    }

    public function test_api_add_new_product_success()
    {
        // Define the new product
        $product = [
            'product_name' => 'Test Product',
            'product_description' => 'This is a test product description.',
            'product_price' => 99.99,
        ];

        // Make a POST request to the endpoint for adding a product
        $response = $this->postJson('/api/products/add', $product);

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert that the product is present in the database
        $this->assertDatabaseHas('products', $product);
    }

    public function test_api_add_new_product_with_missing_required()
    {
        // Define the new product
        $product = [
            'product_name' => 'Test Product',
            'product_description' => '',
            'product_price' => 99.99,
        ];

        // Make a POST request to the endpoint for adding a product
        $response = $this->postJson('/api/products/add', $product);

        // Assert that the response status is 500
        $response->assertStatus(500);

        // Assert that the product is not in the database
        $this->assertDatabaseMissing('products', $product);
    }

    public function test_api_edit_product_success()
    {
        // Create 1 product in the test database
        $product = Product::factory()->create();

        // Define new product details
        $newProduct = [
            'product_name' => 'Test Product',
            'product_description' => 'This is a test product description.',
            'product_price' => 99.99,
        ];

        // Make a PUT request to the endpoint for editing a product
        $response = $this->putJson('/api/products/edit/' . $product->id, $newProduct);

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert that the product is present in the database
        $this->assertDatabaseHas('products', $newProduct);
    }

    public function test_api_edit_product_with_error()
    {
        // Create 1 product in the test database
        $product = Product::factory()->create();

        // Define new product details
        $newProduct = [
            'product_name' => 'Test Product',
            'product_description' => 'This is a test product description.',
            'product_price' => 'This is not allowed',
        ];

        // Make a PUT request to the endpoint for editing a product
        $response = $this->putJson('/api/products/edit/' . $product->id, $newProduct);

        // Assert that the response status is 500
        $response->assertStatus(500);

        // Assert that the product is not in the database
        $this->assertDatabaseMissing('products', $newProduct);

    }
    public function test_api_delete_product_success()
    {
        // Create 1 product in the test database
        $product = Product::factory()->create();

        // Make a DELETE request to the endpoint for deleting a product
        $response = $this->deleteJson('/api/products/delete/' . $product->id);

        // Assert that the response status is 200
        $response->assertStatus(200);

        // Assert that the product is not in the database
        $this->assertDatabaseMissing('products', $product->toArray());
    }

    public function test_api_delete_product_with_error()
    {
        // Create 1 product in the test database
        $product = Product::factory()->create();

        // Make a DELETE request to the endpoint for deleting a product
        $response = $this->deleteJson('/api/products/delete/32.32');

        // Assert that the response status is 404
        $response->assertStatus(404);

        // Assert that the product is in the database
        $this->assertDatabaseHas('products', array_merge(
            $product->toArray(),
            ['updated_at' => $product->updated_at->format('Y-m-d H:i:s')],
            ['created_at' => $product->created_at->format('Y-m-d H:i:s')]
        )
        );
    }
}
