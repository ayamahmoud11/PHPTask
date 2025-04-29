<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductTest extends TestCase
{
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
        
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'customer']);
    }
    

    public function test_admin_can_create_products()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
    
        $response = $this->actingAs($admin)
            ->withoutMiddleware([
                \App\Http\Middleware\VerifyCsrfToken::class,
            ])
            ->postJson('/api/products', [
                'name' => 'Test Product',
                'price' => 10.99,
                'quantity' => 100
            ]);
    
        $response->assertStatus(201);
    }
}