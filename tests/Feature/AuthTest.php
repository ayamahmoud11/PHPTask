<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);
    }
    public function test_register()
    {
        $response = $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ])->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    
        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user', 'token']);
    }
public function test_login()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password')
    ]);
    $user->assignRole('customer');

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['message', 'user', 'token']);
}
}