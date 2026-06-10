<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin-mgmt@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }

    public function test_index_search_filters_by_name_or_email(): void
    {
        $admin = $this->admin();

        User::create(['name' => 'Alice Smith', 'email' => 'alice@x.com', 'password' => 'p', 'role' => 'customer']);
        User::create(['name' => 'Bob Jones', 'email' => 'bob@y.com', 'password' => 'p', 'role' => 'customer']);

        $response = $this->actingAs($admin)->get('/admin/users?q=Alice');

        $response->assertOk();
        $response->assertSee('Alice Smith');
        $response->assertDontSee('Bob Jones');
    }

    public function test_index_filters_by_role(): void
    {
        $admin = $this->admin();

        User::create(['name' => 'A Customer', 'email' => 'c1@x.com', 'password' => 'p', 'role' => 'customer']);
        User::create(['name' => 'A Vendor', 'email' => 'v1@x.com', 'password' => 'p', 'role' => 'vendor']);

        $response = $this->actingAs($admin)->get('/admin/users?role=customer');

        $response->assertOk();
        $response->assertSee('A Customer');
        $response->assertDontSee('A Vendor');
    }

    public function test_create_with_duplicate_email_is_rejected(): void
    {
        $admin = $this->admin();

        User::create(['name' => 'Existing', 'email' => 'dup@x.com', 'password' => 'p', 'role' => 'customer']);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'New',
            'email' => 'dup@x.com',
            'role' => 'customer',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertEquals(1, User::where('email', 'dup@x.com')->count());
    }

    public function test_update_happy_path(): void
    {
        $admin = $this->admin();
        $target = User::create(['name' => 'Old Name', 'email' => 'old@x.com', 'password' => 'p', 'role' => 'customer']);

        $response = $this->actingAs($admin)->put('/admin/users/' . $target->id, [
            'name' => 'New Name',
            'email' => 'new@x.com',
            'role' => 'vendor',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $target->refresh();
        $this->assertEquals('New Name', $target->name);
        $this->assertEquals('vendor', $target->role);
    }

    public function test_soft_delete_and_restore(): void
    {
        $admin = $this->admin();
        $target = User::create(['name' => 'Target', 'email' => 't@x.com', 'password' => 'p', 'role' => 'customer']);

        $this->actingAs($admin)->delete('/admin/users/' . $target->id)->assertRedirect();
        $this->assertSoftDeleted('users', ['id' => $target->id]);

        $this->actingAs($admin)->post('/admin/users/' . $target->id . '/restore')->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $target->id, 'deleted_at' => null]);
    }

    public function test_self_delete_is_blocked(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->delete('/admin/users/' . $admin->id);

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'deleted_at' => null]);
    }

    public function test_self_demote_is_blocked(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->put('/admin/users/' . $admin->id, [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'customer',
        ]);

        $response->assertSessionHasErrors('role');
        $admin->refresh();
        $this->assertEquals('admin', $admin->role);
    }
}
