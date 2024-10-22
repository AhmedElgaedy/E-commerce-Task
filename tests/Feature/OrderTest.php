<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_place_an_order()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::create([
            'name' => 'Test Product',
            'price' => 100.00,
            'description' => 'This is a test product.',
            'stock' => 50,
        ]);

        $orderData = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'user_id',
                     'total_price',
                     'products' => [
                         '*' => [
                             'id',
                             'quantity',
                             'price',
                             'total',
                         ],
                     ],
                 ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 200.00,
        ]);
    }
}
