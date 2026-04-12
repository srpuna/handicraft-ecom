<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class CustomerWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_user_can_view_products()
    {
        Product::factory()->count(3)->create();

        // ProductController::index() redirects to home (products are displayed on homepage).
        $response = $this->get('/products');

        $response->assertRedirect(route('home'));
    }

    public function test_user_can_add_product_to_cart()
    {
        $product = Product::factory()->create();

        // Actual route is POST /cart/add with product_id field.
        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $response->assertRedirect(route('cart.index'));
    }

    public function test_user_can_view_cart()
    {
        $response = $this->get('/cart');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.cart.index');
    }

    public function test_user_can_proceed_to_checkout()
    {
        $product = Product::factory()->create();

        // Populate session cart using the correct route before visiting checkout.
        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);

        $response = $this->get('/checkout');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.cart.checkout');
    }
}
