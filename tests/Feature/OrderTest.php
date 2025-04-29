<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OrderTest extends TestCase
{ use WithoutMiddleware;
    protected function setUp(): void
    {
        parent::setUp();
        
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
            Role::create(['name' => 'customer']);
        }
        
        $this->customer = User::factory()->create();
        $this->customer->assignRole('customer');
        
        $this->product = Product::factory()->create([
            'quantity' => 10,
            'price' => 19.99,
        ]);
    }

    public function test_allows_customer_to_create_order()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $product = Product::factory()->create([
            'quantity' => 10,
            'price' => 19.99
        ]);
    
        $response = $this->actingAs($customer)
            ->withoutMiddleware([
                \App\Http\Middleware\VerifyCsrfToken::class,
            ])
            ->postJson('/api/orders', [
                'items' => [
                    [
                        'product_id' => $product->id,
                        'quantity' => 2
                    ]
                ]
            ]);
    
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'total_price', 'items']);
    }
}