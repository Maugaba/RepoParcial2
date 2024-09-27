<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_product()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Prueba creacion',
            'description' => 'Prueba de creacion de producto',
            'price' => 99.99,
            'stock' => 10,
            'sku' => 'SKU123',
            'category' => 'Categoria de prueba',
            'especial_price' => '79.99',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['name' => 'Prueba creacion']);
    }

    public function test_get_all_products() 
    {
        Product::factory()->count(3)->create();
        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
    
    
    public function test_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson(['name' => $product->name]);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Producto actualizado',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['name' => 'Producto actualizado']);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
