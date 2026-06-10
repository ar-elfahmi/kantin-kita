<?php

namespace Tests\Feature\Admin;

use App\Models\DetailPesanan;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTransaksiTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin-tx@test.local',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }

    private function makeVendor(string $email, string $name): Vendor
    {
        $u = User::create(['name' => $name, 'email' => $email, 'password' => 'p', 'role' => 'vendor']);
        return Vendor::create([
            'user_id' => $u->id,
            'nama_vendor' => $name,
            'lokasi' => 'A',
            'kategori' => 'Indonesia',
            'rating' => 4.5,
            'is_open' => true,
        ]);
    }

    private function makePesanan(Vendor $vendor, string $payStatus, string $orderStatus, ?string $createdAt = null, ?string $customerName = null): Pesanan
    {
        $customerName = $customerName ?? ('Cust-' . uniqid());
        $customer = User::create([
            'name' => $customerName,
            'email' => 'cust-' . uniqid() . '@x.com',
            'password' => 'p',
            'role' => 'customer',
        ]);
        $p = Pesanan::create([
            'user_id' => $customer->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => $customerName,
            'total' => 10000,
            'status_pesanan' => $orderStatus,
        ]);
        if ($createdAt) {
            $p->created_at = $createdAt;
            $p->save();
        }
        Payment::create([
            'pesanan_id' => $p->id,
            'gross_amount' => 10000,
            'status' => $payStatus,
        ]);
        return $p;
    }

    public function test_index_is_accessible_and_paginated(): void
    {
        $admin = $this->admin();
        $v = $this->makeVendor('v1@x.com', 'V1');

        for ($i = 0; $i < 5; $i++) {
            $this->makePesanan($v, 'settlement', 'selesai');
        }

        $this->actingAs($admin)->get('/admin/transaksi')->assertOk();
    }

    public function test_filter_by_vendor(): void
    {
        $admin = $this->admin();
        $a = $this->makeVendor('va@x.com', 'Vendor Alpha');
        $b = $this->makeVendor('vb@x.com', 'Vendor Beta');

        $this->makePesanan($a, 'settlement', 'selesai', null, 'AlphaCustomerXYZ');
        $this->makePesanan($b, 'settlement', 'selesai', null, 'BetaCustomerXYZ');

        $response = $this->actingAs($admin)->get('/admin/transaksi?vendor_id=' . $a->id);

        $response->assertOk();
        $response->assertSee('AlphaCustomerXYZ');
        $response->assertDontSee('BetaCustomerXYZ');
    }

    public function test_filter_by_payment_status(): void
    {
        $admin = $this->admin();
        $v = $this->makeVendor('vp@x.com', 'VP');

        $this->makePesanan($v, 'settlement', 'selesai', null, 'SettledCustomerXYZ');
        $this->makePesanan($v, 'pending', 'pending', null, 'PendingCustomerXYZ');

        $response = $this->actingAs($admin)->get('/admin/transaksi?payment_status=settlement');

        $response->assertOk();
        $response->assertSee('SettledCustomerXYZ');
        $response->assertDontSee('PendingCustomerXYZ');
    }

    public function test_filter_by_order_status(): void
    {
        $admin = $this->admin();
        $v = $this->makeVendor('vo@x.com', 'VO');

        $this->makePesanan($v, 'settlement', 'selesai', null, 'SelesaiCustomerXYZ');
        $this->makePesanan($v, 'pending', 'pending', null, 'PendingOrderCustomerXYZ');

        $response = $this->actingAs($admin)->get('/admin/transaksi?order_status=selesai');

        $response->assertOk();
        $response->assertSee('SelesaiCustomerXYZ');
        $response->assertDontSee('PendingOrderCustomerXYZ');
    }

    public function test_filter_by_date_range(): void
    {
        $admin = $this->admin();
        $v = $this->makeVendor('vd@x.com', 'VD');

        $this->makePesanan($v, 'settlement', 'selesai', '2025-01-01 10:00:00', 'OldCustomerXYZ');
        $this->makePesanan($v, 'settlement', 'selesai', '2026-06-01 10:00:00', 'NewCustomerXYZ');

        $response = $this->actingAs($admin)->get('/admin/transaksi?start_date=2026-01-01&end_date=2026-12-31');

        $response->assertOk();
        $response->assertSee('NewCustomerXYZ');
        $response->assertDontSee('OldCustomerXYZ');
    }

    public function test_detail_page_renders_line_items(): void
    {
        $admin = $this->admin();
        $v = $this->makeVendor('vdetail@x.com', 'VDetail');

        $kategori = KategoriMenu::create(['nama_kategori' => 'Makanan']);
        $menu = Menu::create([
            'vendor_id' => $v->id,
            'kategori_menu_id' => $kategori->id,
            'nama_menu' => 'Nasi Goreng Spesial',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $p = $this->makePesanan($v, 'settlement', 'selesai');
        DetailPesanan::create([
            'pesanan_id' => $p->id,
            'menu_id' => $menu->id,
            'jumlah' => 2,
            'harga' => 15000,
            'subtotal' => 30000,
        ]);

        $response = $this->actingAs($admin)->get('/admin/transaksi/' . $p->id);

        $response->assertOk();
        $response->assertSee('Nasi Goreng Spesial');
        $response->assertSee('30.000');
    }
}
