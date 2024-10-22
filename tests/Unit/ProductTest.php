<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 100.00,
            'description' => 'This is a test product.',
            'stock' => 50,
        ];

        $product = Product::create($productData);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 100.00,
            'description' => 'This is a test product.',
            'stock' => 50,
        ]);
    }
}
