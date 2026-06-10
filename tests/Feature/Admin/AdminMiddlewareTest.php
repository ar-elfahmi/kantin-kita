<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_visiting_admin_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_vendor_visiting_admin_gets_403(): void
    {
        $vendor = User::create([
            'name' => 'Vendor',
            'email' => 'v@test.local',
            'password' => 'password',
            'role' => 'vendor',
        ]);

        $this->actingAs($vendor)->get('/admin')->assertForbidden();
    }

    public function test_customer_visiting_admin_gets_403(): void
    {
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'c@test.local',
            'password' => 'password',
            'role' => 'customer',
        ]);

        $this->actingAs($customer)->get('/admin')->assertForbidden();
    }

    public function test_admin_visiting_admin_gets_200(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'a@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}
