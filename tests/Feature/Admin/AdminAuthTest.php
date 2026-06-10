<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_vendor_login_still_redirects_to_dashboard(): void
    {
        $user = User::create([
            'name' => 'Vendor',
            'email' => 'vendor@test.local',
            'password' => 'password',
            'role' => 'vendor',
        ]);

        Vendor::create([
            'user_id' => $user->id,
            'nama_vendor' => 'Test Vendor',
            'lokasi' => 'A',
            'kategori' => 'Indonesia',
            'rating' => 4.5,
            'is_open' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_customer_role_is_rejected_with_error(): void
    {
        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@test.local',
            'password' => 'password',
            'role' => 'customer',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_role_is_rejected_with_error(): void
    {
        $user = User::create([
            'name' => 'Guest',
            'email' => 'guest@test.local',
            'password' => 'password',
            'role' => 'guest',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_wrong_password_is_rejected(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin2@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'admin2@test.local',
            'password' => 'salah',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
