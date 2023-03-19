<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Validation\ValidationException;

class ProductTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
public function it_returns_a_list_of_all_products()
{
    Product::factory()->count(3)->create();

    $products = Product::all();

    $response = $this->call('GET', '/api/products');
    $response->assertStatus(200);
    $response->assertJsonCount($products->count());
}


    /** @test */
    public function testStoreMethodCreatesNewProduct()
    {
        $requestData = [
            'title' => 'Test title',
            'description' => 'Test description',
        ];
        $request = Request::create('/api/products', 'POST', $requestData);
        $controller = new ProductController();
        $response = $this->call('POST', '/api/products', $requestData);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertDatabaseHas('products', $requestData);
    }

    /** @test */
    public function test_store_fails_validation()
    {
        $requestData = [
            'description' => 'Test description',
        ];
        $request = new Request($requestData);
        $productMock = $this->createMock(Product::class);
        $controller = new ProductController($productMock);
        $this->expectException(ValidationException::class);
        $controller->store($request);
    }

    /** @test */
    public function testShow()
    {
        $product = Product::factory()->create();
        $response = $this->get("/api/products/{$product->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment($product->toArray());
    }
}
