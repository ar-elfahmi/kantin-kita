<?php

namespace Tests\Feature;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KantinFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_login_and_is_redirected_to_dashboard(): void
    {
        $vendorUser = $this->createVendorUser('vendor-login@kantinkita.id', 'Vendor Login');

        $response = $this->post('/login', [
            'email' => $vendorUser->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($vendorUser);
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_vendor_page_is_public_and_lists_only_open_vendors(): void
    {
        $openVendor = $this->createVendorUser('open@kantinkita.id', 'Warung Buka', true);
        $closedVendor = $this->createVendorUser('closed@kantinkita.id', 'Warung Tutup', false);

        $response = $this->get('/vendor');

        $response->assertOk();
        $response->assertSee($openVendor->vendor->nama_vendor);
        $response->assertDontSee($closedVendor->vendor->nama_vendor);
    }

    public function test_vendor_menu_page_shows_items_for_the_selected_vendor_only(): void
    {
        $vendorA = $this->createVendorUser('vendor-a@kantinkita.id', 'Vendor A');
        $vendorB = $this->createVendorUser('vendor-b@kantinkita.id', 'Vendor B');

        $menuA = Menu::create([
            'vendor_id' => $vendorA->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Vendor A',
            'deskripsi' => 'Menu khusus vendor A',
            'harga' => 12000,
            'is_available' => true,
        ]);

        $menuB = Menu::create([
            'vendor_id' => $vendorB->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Vendor B',
            'deskripsi' => 'Menu khusus vendor B',
            'harga' => 14000,
            'is_available' => true,
        ]);

        $response = $this->get("/vendor/{$vendorA->vendor->id}/menu");

        $response->assertOk();
        $response->assertSee($menuA->nama_menu);
        $response->assertDontSee($menuB->nama_menu);
    }

    public function test_dashboard_shows_only_settlement_orders(): void
    {
        $vendorUser = $this->createVendorUser('vendor-dashboard@kantinkita.id', 'Vendor Dashboard');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Nasi Uji Dashboard',
            'deskripsi' => 'Untuk test dashboard',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $guestSettlement = User::create([
            'name' => 'Customer Settlement',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $settlementOrder = Pesanan::create([
            'user_id' => $guestSettlement->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Settlement',
            'total' => 30000,
            'status_pesanan' => 'diproses',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $settlementOrder->id,
            'menu_id' => $menu->id,
            'jumlah' => 2,
            'harga' => 15000,
            'subtotal' => 30000,
        ]);

        Payment::create([
            'pesanan_id' => $settlementOrder->id,
            'gross_amount' => 30000,
            'status' => 'settlement',
            'payment_type' => 'qris',
        ]);

        $guestPending = User::create([
            'name' => 'Customer Pending',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pendingOrder = Pesanan::create([
            'user_id' => $guestPending->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Pending',
            'total' => 15000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pendingOrder->id,
            'gross_amount' => 15000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $response = $this->actingAs($vendorUser)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Customer Settlement');
        $response->assertDontSee('Customer Pending');
    }

    public function test_vendor_can_mark_diproses_order_as_selesai(): void
    {
        $vendorUser = $this->createVendorUser('vendor-complete@kantinkita.id', 'Vendor Complete');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Customer Diproses',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Diproses',
            'total' => 32000,
            'status_pesanan' => 'diproses',
        ]);

        $response = $this->actingAs($vendorUser)
            ->from('/dashboard')
            ->post(route('dashboard.orders.complete', ['pesanan' => $pesanan->id]));

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('orderSuccess');

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'selesai',
        ]);
    }

    public function test_vendor_cannot_mark_other_vendor_order_as_selesai(): void
    {
        $vendorUserA = $this->createVendorUser('vendor-a-complete@kantinkita.id', 'Vendor A Complete');
        $vendorUserB = $this->createVendorUser('vendor-b-complete@kantinkita.id', 'Vendor B Complete');

        $guestUser = User::create([
            'name' => 'Customer Lain',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesananVendorB = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendorUserB->vendor->id,
            'nama_customer' => 'Customer Lain',
            'total' => 28000,
            'status_pesanan' => 'diproses',
        ]);

        $response = $this->actingAs($vendorUserA)
            ->post(route('dashboard.orders.complete', ['pesanan' => $pesananVendorB->id]));

        $response->assertStatus(403);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesananVendorB->id,
            'status_pesanan' => 'diproses',
        ]);
    }

    public function test_checkout_store_persists_waktu_pengambilan_from_payload(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorUser = $this->createVendorUser('vendor-pickup@kantinkita.id', 'Vendor Pickup');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Pickup Time',
            'deskripsi' => 'Menu untuk test waktu pengambilan',
            'harga' => 16000,
            'is_available' => true,
        ]);

        \Mockery::mock('alias:Midtrans\\Snap')
            ->shouldReceive('getSnapToken')
            ->once()
            ->andReturn('snap-token-pickup-time');

        $response = $this->postJson('/api/checkout', [
            'nama_customer' => 'Customer Pickup Time',
            'vendor_id' => $vendor->id,
            'waktu_pengambilan' => '12:30',
            'items' => [
                [
                    'menu_id' => $menu->id,
                    'jumlah' => 2,
                    'catatan' => 'Tanpa sambal',
                ],
            ],
        ]);

        $response->assertOk()->assertJson([
            'snap_token' => 'snap-token-pickup-time',
        ]);

        $pesananId = $response->json('pesanan_id');
        $this->assertNotNull($pesananId);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesananId,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Pickup Time',
            'waktu_pengambilan' => '12:30',
            'status_pesanan' => 'pending',
            'total' => 32000,
        ]);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesananId,
            'snap_token' => 'snap-token-pickup-time',
            'status' => 'pending',
            'gross_amount' => 32000,
        ]);
    }

    public function test_checkout_update_status_success_marks_payment_settlement_and_order_diproses(): void
    {
        $vendorUser = $this->createVendorUser('vendor-success@kantinkita.id', 'Vendor Success');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest Success',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest Success',
            'total' => 18000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-x',
            'gross_amount' => 18000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $response = $this->postJson('/api/checkout/update-status', [
            'pesanan_id' => $pesanan->id,
            'transaction_id' => 'trx-success-123',
            'payment_type' => 'qris',
            'status' => 'success',
            'result' => [
                'transaction_status' => 'settlement',
            ],
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'settlement',
            'transaction_id' => 'trx-success-123',
            'payment_type' => 'qris',
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'diproses',
        ]);
    }

    public function test_checkout_update_status_error_marks_payment_cancel_and_order_dibatalkan(): void
    {
        $vendorUser = $this->createVendorUser('vendor-error@kantinkita.id', 'Vendor Error');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest Error',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest Error',
            'total' => 20000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-y',
            'gross_amount' => 20000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $response = $this->postJson('/api/checkout/update-status', [
            'pesanan_id' => $pesanan->id,
            'transaction_id' => 'trx-error-123',
            'payment_type' => 'qris',
            'status' => 'error',
            'result' => [
                'transaction_status' => 'cancel',
            ],
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'cancel',
            'transaction_id' => 'trx-error-123',
            'payment_type' => 'qris',
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'dibatalkan',
        ]);
    }

    public function test_midtrans_notification_settlement_updates_payment_and_order(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorUser = $this->createVendorUser('vendor-notif@kantinkita.id', 'Vendor Notification');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest Notification',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest Notification',
            'total' => 25000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-notif',
            'gross_amount' => 25000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $orderId = 'KK-' . $pesanan->id . '-' . now()->timestamp;
        $grossAmount = '25000.00';
        $statusCode = '200';
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_id' => 'trx-notif-123',
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'fraud_status' => 'accept',
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'settlement',
            'transaction_id' => 'trx-notif-123',
            'payment_type' => 'qris',
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'diproses',
        ]);
    }

    public function test_midtrans_notification_rejects_invalid_signature(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorUser = $this->createVendorUser('vendor-notif-invalid@kantinkita.id', 'Vendor Notification Invalid');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest Notification Invalid',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest Notification Invalid',
            'total' => 26000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-notif-invalid',
            'gross_amount' => 26000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $orderId = 'KK-' . $pesanan->id . '-' . now()->timestamp;

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => '200',
            'gross_amount' => '26000.00',
            'signature_key' => 'invalid-signature',
            'transaction_id' => 'trx-notif-invalid',
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'fraud_status' => 'accept',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'pending',
            'transaction_id' => null,
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'pending',
        ]);
    }

    public function test_vendor_cannot_mark_non_diproses_order_as_selesai(): void
    {
        $vendorUser = $this->createVendorUser('vendor-non-diproses@kantinkita.id', 'Vendor Non Diproses');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Customer Pending Order',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Pending Order',
            'total' => 22000,
            'status_pesanan' => 'pending',
        ]);

        $response = $this->actingAs($vendorUser)
            ->from('/dashboard')
            ->post(route('dashboard.orders.complete', ['pesanan' => $pesanan->id]));

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('orderError');

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'pending',
        ]);
    }

    public function test_checkout_store_rejects_items_from_different_vendor(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorA = $this->createVendorUser('vendor-mixed-a@kantinkita.id', 'Vendor Mixed A');
        $vendorB = $this->createVendorUser('vendor-mixed-b@kantinkita.id', 'Vendor Mixed B');

        $menuA = Menu::create([
            'vendor_id' => $vendorA->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Vendor Mixed A',
            'deskripsi' => 'Menu A',
            'harga' => 12000,
            'is_available' => true,
        ]);

        $menuB = Menu::create([
            'vendor_id' => $vendorB->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Vendor Mixed B',
            'deskripsi' => 'Menu B',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $response = $this->postJson('/api/checkout', [
            'nama_customer' => 'Customer Mixed Vendor',
            'vendor_id' => $vendorA->vendor->id,
            'waktu_pengambilan' => '13:00',
            'items' => [
                [
                    'menu_id' => $menuA->id,
                    'jumlah' => 1,
                    'catatan' => null,
                ],
                [
                    'menu_id' => $menuB->id,
                    'jumlah' => 1,
                    'catatan' => null,
                ],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Semua item harus berasal dari vendor yang sama.',
        ]);

        $this->assertDatabaseCount('pesanans', 0);
        $this->assertDatabaseCount('payments', 0);
    }

    public function test_midtrans_notification_rejects_invalid_order_id_format(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $orderId = 'INVALID-ORDER-ID';
        $statusCode = '200';
        $grossAmount = '11000.00';
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'fraud_status' => 'accept',
        ]);

        $response->assertStatus(422)->assertJson([
            'message' => 'Order ID format is invalid.',
        ]);
    }

    public function test_midtrans_notification_capture_challenge_keeps_payment_pending(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorUser = $this->createVendorUser('vendor-challenge@kantinkita.id', 'Vendor Challenge');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest Challenge',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest Challenge',
            'total' => 21000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-challenge',
            'gross_amount' => 21000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $orderId = 'KK-' . $pesanan->id . '-' . now()->timestamp;
        $statusCode = '200';
        $grossAmount = '21000.00';
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_id' => 'trx-challenge-123',
            'transaction_status' => 'capture',
            'payment_type' => 'qris',
            'fraud_status' => 'challenge',
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'pending',
            'transaction_id' => 'trx-challenge-123',
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'pending',
        ]);
    }

    public function test_midtrans_notification_does_not_downgrade_settlement_to_cancel(): void
    {
        config(['midtrans.server_key' => 'midtrans-server-key-test']);

        $vendorUser = $this->createVendorUser('vendor-no-downgrade@kantinkita.id', 'Vendor No Downgrade');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Guest No Downgrade',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Guest No Downgrade',
            'total' => 33000,
            'status_pesanan' => 'diproses',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'snap_token' => 'snap-token-settlement',
            'gross_amount' => 33000,
            'status' => 'settlement',
            'payment_type' => 'qris',
            'transaction_id' => 'trx-settlement-123',
            'paid_at' => now(),
        ]);

        $orderId = 'KK-' . $pesanan->id . '-' . now()->timestamp;
        $statusCode = '200';
        $grossAmount = '33000.00';
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_id' => 'trx-cancel-late',
            'transaction_status' => 'cancel',
            'payment_type' => 'qris',
            'fraud_status' => 'accept',
        ]);

        $response->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('payments', [
            'pesanan_id' => $pesanan->id,
            'status' => 'settlement',
        ]);

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'diproses',
        ]);
    }

    public function test_lookup_order_by_barcode_success(): void
    {
        $vendorUser = $this->createVendorUser('vendor-scan@kantinkita.id', 'Vendor Scan');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Customer Barcode',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Nasi Barcode',
            'deskripsi' => 'Menu untuk test barcode',
            'harga' => 18000,
            'is_available' => true,
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Barcode',
            'total' => 36000,
            'status_pesanan' => 'diproses',
            'waktu_pengambilan' => '12:30',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'menu_id' => $menu->id,
            'jumlah' => 2,
            'harga' => 18000,
            'subtotal' => 36000,
        ]);

        $orderId = 'KK-' . $pesanan->id . '-' . now()->timestamp;

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'gross_amount' => 36000,
            'status' => 'settlement',
            'payment_type' => 'qris',
            'midtrans_response' => [
                'order_id' => $orderId,
            ],
        ]);

        $response = $this->actingAs($vendorUser)
            ->getJson('/api/checkout/by-order-id/' . urlencode($orderId));

        $response->assertOk();
        $response->assertJson([
            'order_id' => $orderId,
            'pesanan_id' => $pesanan->id,
            'nama_customer' => 'Customer Barcode',
            'vendor_id' => $vendor->id,
            'vendor_name' => 'Vendor Scan',
            'total' => 36000,
            'status_pesanan' => 'diproses',
            'waktu_pengambilan' => '12:30',
            'payment_status' => 'settlement',
        ]);
        $response->assertJsonStructure([
            'items' => [
                '*' => ['nama_menu', 'jumlah', 'harga', 'subtotal', 'catatan'],
            ],
        ]);
        $this->assertCount(1, $response->json('items'));
        $this->assertEquals('Nasi Barcode', $response->json('items.0.nama_menu'));
    }

    public function test_lookup_order_by_barcode_invalid_format(): void
    {
        $vendorUser = $this->createVendorUser('vendor-format@kantinkita.id', 'Vendor Format');

        $response = $this->actingAs($vendorUser)
            ->getJson('/api/checkout/by-order-id/INVALID-FORMAT');

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Format order ID tidak valid.',
        ]);
    }

    public function test_lookup_order_by_barcode_not_found(): void
    {
        $vendorUser = $this->createVendorUser('vendor-nf@kantinkita.id', 'Vendor Not Found');

        $response = $this->actingAs($vendorUser)
            ->getJson('/api/checkout/by-order-id/KK-99999-1713100800');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Pesanan tidak ditemukan.',
        ]);
    }

    public function test_lookup_order_by_barcode_requires_authentication(): void
    {
        $response = $this->getJson('/api/checkout/by-order-id/KK-1-1713100800');

        $response->assertStatus(401);
    }

    public function test_lookup_order_by_barcode_mismatch_order_id_returns_not_found(): void
    {
        $vendorUser = $this->createVendorUser('vendor-mismatch@kantinkita.id', 'Vendor Mismatch');
        $vendor = $vendorUser->vendor;

        $guestUser = User::create([
            'name' => 'Customer Mismatch',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Mismatch',
            'total' => 15000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'gross_amount' => 15000,
            'status' => 'pending',
            'payment_type' => 'qris',
            'midtrans_response' => [
                'order_id' => 'KK-' . $pesanan->id . '-9999999999',
            ],
        ]);

        $response = $this->actingAs($vendorUser)
            ->getJson('/api/checkout/by-order-id/KK-' . $pesanan->id . '-1111111111');

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Pesanan tidak ditemukan.',
        ]);
    }

    public function test_login_page_renders_for_guest(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Login');
    }

    public function test_login_redirects_already_authenticated_to_dashboard(): void
    {
        $vendorUser = $this->createVendorUser('auth-redir@kantinkita.id', 'Auth Redirect');

        $response = $this->actingAs($vendorUser)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $this->createVendorUser('real@kantinkita.id', 'Real Vendor');

        $response = $this->post('/login', [
            'email' => 'real@kantinkita.id',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_for_non_panel_role(): void
    {
        User::create([
            'name' => 'Customer',
            'email' => 'customer@kantinkita.id',
            'password' => 'custpass',
            'role' => 'customer',
        ]);

        $response = $this->post('/login', [
            'email' => 'customer@kantinkita.id',
            'password' => 'custpass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_clears_session_and_redirects(): void
    {
        $vendorUser = $this->createVendorUser('logout@kantinkita.id', 'Logout Test');

        $this->actingAs($vendorUser);
        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_vendor_page_shows_empty_state_when_no_open_vendors(): void
    {
        $this->createVendorUser('closed@kantinkita.id', 'Vendor Closed', false);

        $response = $this->get('/vendor');

        $response->assertOk();
        $response->assertDontSee('Vendor Closed');
    }

    public function test_vendor_menu_page_returns_404_for_nonexistent_vendor(): void
    {
        $response = $this->get('/vendor/99999/menu');

        $response->assertStatus(404);
    }

    public function test_checkout_page_loads_with_vendor(): void
    {
        $vendorUser = $this->createVendorUser('checkout-vendor@kantinkita.id', 'Checkout Vendor');

        $response = $this->get('/checkout?vendor_id=' . $vendorUser->vendor->id);

        $response->assertOk();
    }

    public function test_checkout_page_loads_without_vendor_id(): void
    {
        $response = $this->get('/checkout');

        $response->assertOk();
    }

    public function test_order_success_page_loads(): void
    {
        $vendorUser = $this->createVendorUser('order-success@kantinkita.id', 'Order Success');
        $guestUser = User::create([
            'name' => 'Success Customer',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);
        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendorUser->vendor->id,
            'nama_customer' => 'Success Customer',
            'total' => 10000,
            'status_pesanan' => 'selesai',
        ]);

        $response = $this->get("/order/{$pesanan->id}");

        $response->assertOk();
        $response->assertSee('Success Customer');
    }

    public function test_checkout_store_fails_without_midtrans_config(): void
    {
        config(['midtrans.server_key' => '']);

        $vendorUser = $this->createVendorUser('no-midtrans@kantinkita.id', 'No Midtrans');
        $menu = Menu::create([
            'vendor_id' => $vendorUser->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Test No Midtrans',
            'deskripsi' => 'Test',
            'harga' => 10000,
            'is_available' => true,
        ]);

        $response = $this->postJson('/api/checkout', [
            'nama_customer' => 'Customer No Midtrans',
            'vendor_id' => $vendorUser->vendor->id,
            'items' => [
                ['menu_id' => $menu->id, 'jumlah' => 1],
            ],
        ]);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Konfigurasi pembayaran Midtrans belum lengkap. Periksa MIDTRANS_SERVER_KEY.',
        ]);
    }

    public function test_dashboard_returns_403_for_user_without_vendor_profile(): void
    {
        $adminUser = User::create([
            'name' => 'Admin No Vendor',
            'email' => 'admin-novendor@kantinkita.id',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($adminUser)->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_dashboard_shows_empty_state_no_orders(): void
    {
        $vendorUser = $this->createVendorUser('empty-dash@kantinkita.id', 'Empty Dashboard');

        $response = $this->actingAs($vendorUser)->get('/dashboard');

        $response->assertOk();
    }

    public function test_chatbot_returns_422_for_empty_prompt(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_chatbot_returns_422_for_too_long_prompt(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => str_repeat('a', 401),
        ]);

        $response->assertStatus(422);
    }

    public function test_chatbot_greeting_intent_responds(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'halo, apa kabar?',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Halo', $response->json('result'));
    }

    public function test_chatbot_top_menu_intent_without_orders(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'menu terlaris hari ini',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('belum tersedia', $response->json('result'));
    }

    public function test_chatbot_top_menu_intent_with_orders(): void
    {
        $vendorUser = $this->createVendorUser('top-menu-vendor@kantinkita.id', 'Top Menu Vendor');
        $menu = Menu::create([
            'vendor_id' => $vendorUser->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Terlaris',
            'deskripsi' => 'Menu paling laku',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'menu terlaris apa?',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('paling sering dipesan', $response->json('result'));
        $this->assertStringContainsString('Menu Terlaris', $response->json('result'));
    }

    public function test_chatbot_affordable_menu_intent_with_data(): void
    {
        $vendorUser = $this->createVendorUser('affordable@kantinkita.id', 'Affordable Vendor');
        Menu::create([
            'vendor_id' => $vendorUser->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Nasi Hemat',
            'deskripsi' => 'Menu murah',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'menu hemat',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Rekomendasi menu hemat', $response->json('result'));
        $this->assertStringContainsString('Nasi Hemat', $response->json('result'));
    }

    public function test_chatbot_affordable_menu_intent_empty(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'menu di bawah 20 ribu',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Belum ada menu', $response->json('result'));
    }

    public function test_chatbot_spicy_menu_intent_with_data(): void
    {
        $vendorUser = $this->createVendorUser('spicy@kantinkita.id', 'Spicy Vendor');
        Menu::create([
            'vendor_id' => $vendorUser->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Nasi Goreng Pedas',
            'deskripsi' => 'Menu pedas',
            'harga' => 18000,
            'is_available' => true,
        ]);

        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'menu pedas dong',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('rekomendasi menu pedas', $response->json('result'));
        $this->assertStringContainsString('Nasi Goreng Pedas', $response->json('result'));
    }

    public function test_chatbot_spicy_menu_intent_empty(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'ada geprek?',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Menu pedas belum banyak tersedia', $response->json('result'));
    }

    public function test_chatbot_operational_intent_with_open_vendors(): void
    {
        $this->createVendorUser('op-vendor@kantinkita.id', 'Operational Vendor');

        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'jam operasional kantin',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Vendor yang sedang buka', $response->json('result'));
        $this->assertStringContainsString('Operational Vendor', $response->json('result'));
    }

    public function test_chatbot_operational_intent_without_open_vendors(): void
    {
        $this->createVendorUser('closed-op@kantinkita.id', 'Closed Vendor', false);

        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'kantin buka jam berapa?',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Belum ada vendor', $response->json('result'));
    }

    public function test_chatbot_order_instructions_intent(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'bagaimana cara pesan',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Cara pesan tanpa antre', $response->json('result'));
    }

    public function test_chatbot_payment_info_intent(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'pembayaran apa saja',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Pembayaran', $response->json('result'));
    }

    public function test_chatbot_fallback_intent(): void
    {
        $response = $this->postJson('/api/chatbot/respond', [
            'prompt' => 'siapa presiden indonesia',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Coba tanya salah satu ini', $response->json('result'));
    }

    public function test_checkout_update_status_returns_422_for_nonexistent_pesanan(): void
    {
        $response = $this->postJson('/api/checkout/update-status', [
            'pesanan_id' => 99999,
            'status' => 'success',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['pesanan_id']);
    }

    public function test_checkout_update_status_returns_422_for_invalid_status(): void
    {
        $vendorUser = $this->createVendorUser('invalid-status@kantinkita.id', 'Invalid Status');
        $guestUser = User::create([
            'name' => 'Invalid Status Guest',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);
        $pesanan = Pesanan::create([
            'user_id' => $guestUser->id,
            'vendor_id' => $vendorUser->vendor->id,
            'nama_customer' => 'Invalid Status Guest',
            'total' => 10000,
            'status_pesanan' => 'pending',
        ]);

        $response = $this->postJson('/api/checkout/update-status', [
            'pesanan_id' => $pesanan->id,
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422);
    }

    public function test_price_tag_download_returns_200_for_vendor_own_menu(): void
    {
        $vendorUser = $this->createVendorUser('ptag-own@kantinkita.id', 'PTag Own');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Menu PTag',
            'harga' => 10000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($vendorUser)
            ->get("/menu/{$menu->id}/price-tag");

        $response->assertOk();
    }

    public function test_price_tag_returns_403_for_non_vendor_user(): void
    {
        $vendorUser = $this->createVendorUser('ptag-nv@kantinkita.id', 'PTag NV');
        $vendor = $vendorUser->vendor;

        $guest = User::create([
            'name' => 'Guest',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Menu PTag',
            'harga' => 10000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($guest)
            ->get("/menu/{$menu->id}/price-tag");

        $response->assertStatus(403);
    }

    public function test_price_tag_returns_403_for_another_vendor_menu(): void
    {
        $vendorA = $this->createVendorUser('ptag-va@kantinkita.id', 'PTag VA');
        $vendorB = $this->createVendorUser('ptag-vb@kantinkita.id', 'PTag VB');

        $menu = Menu::create([
            'vendor_id' => $vendorA->vendor->id,
            'nama_menu' => 'Menu PTag A',
            'harga' => 10000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($vendorB)
            ->get("/menu/{$menu->id}/price-tag");

        $response->assertStatus(403);
    }

    public function test_price_tag_returns_404_for_nonexistent_menu(): void
    {
        $vendorUser = $this->createVendorUser('ptag-404@kantinkita.id', 'PTag 404');

        $response = $this->actingAs($vendorUser)
            ->get('/menu/99999/price-tag');

        $response->assertStatus(404);
    }

    public function test_price_tag_content_type_is_pdf(): void
    {
        $vendorUser = $this->createVendorUser('ptag-pdf@kantinkita.id', 'PTag PDF');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Menu PDF',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($vendorUser)
            ->get("/menu/{$menu->id}/price-tag");

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_id_barang_auto_generated_on_menu_create(): void
    {
        $vendorUser = $this->createVendorUser('ptag-idb@kantinkita.id', 'PTag IDB');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Menu Auto ID',
            'harga' => 12000,
            'is_available' => true,
        ]);

        $this->assertNotNull($menu->id_barang);
        $this->assertSame(8, strlen($menu->id_barang));
    }

    public function test_price_tag_contains_barcode_image(): void
    {
        $vendorUser = $this->createVendorUser('ptag-bc@kantinkita.id', 'PTag BC');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Menu Barcode',
            'harga' => 20000,
            'is_available' => true,
        ]);

        $response = $this->actingAs($vendorUser)
            ->get("/menu/{$menu->id}/price-tag");

        $response->assertOk();
        $response->assertDownload('price-tag-' . $menu->id_barang . '.pdf');
    }

    public function test_id_barang_column_is_non_nullable_after_backfill(): void
    {
        $vendorUser = $this->createVendorUser('backfill-nn@kantinkita.id', 'Backfill NN');
        $vendor = $vendorUser->vendor;

        $this->expectException(\Illuminate\Database\QueryException::class);

        DB::table('menus')->insert([
            'vendor_id' => $vendor->id,
            'nama_menu' => 'Test Null',
            'harga' => 10000,
        ]);
    }

    public function test_vendor_card_is_clickable_with_a11y_attrs(): void
    {
        $vendor = $this->createVendorUser('clickable@kantinkita.id', 'Warung Click');

        $response = $this->get('/vendor');

        $response->assertOk();
        $expectedHref = route('menu', ['id' => $vendor->vendor->id]);
        $response->assertSee('data-href="' . e($expectedHref) . '"', false);
        $response->assertSee('role="link"', false);
        $response->assertSee('tabindex="0"', false);
        $response->assertSee('aria-label="Buka menu ' . e($vendor->vendor->nama_vendor) . '"', false);
    }

    public function test_menu_card_is_clickable_with_a11y_attrs(): void
    {
        $vendor = $this->createVendorUser('menu-click@kantinkita.id', 'Warung Menu Click');

        $menu = Menu::create([
            'vendor_id' => $vendor->vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Click Test',
            'deskripsi' => 'Menu untuk uji klik',
            'harga' => 15000,
            'is_available' => true,
        ]);

        $response = $this->get("/vendor/{$vendor->vendor->id}/menu");

        $response->assertOk();
        $response->assertSee('role="button"', false);
        $response->assertSee('tabindex="0"', false);
        $response->assertSee('aria-label="Lihat detail ' . e($menu->nama_menu) . '"', false);
    }

    public function test_manage_orders_page_requires_authentication(): void
    {
        $this->get('/dashboard/pesanan')->assertRedirect('/login');
    }

    public function test_manage_orders_page_forbidden_for_non_vendor(): void
    {
        $guest = User::create([
            'name' => 'Bukan Vendor',
            'email' => 'bukan-vendor@kantinkita.id',
            'password' => 'password',
            'role' => 'guest',
        ]);

        $this->actingAs($guest)
            ->get('/dashboard/pesanan')
            ->assertStatus(403);
    }

    public function test_manage_orders_page_shows_only_paid_orders_for_vendor(): void
    {
        $vendorUser = $this->createVendorUser('vendor-orders@kantinkita.id', 'Vendor Orders');
        $vendor = $vendorUser->vendor;

        $menu = Menu::create([
            'vendor_id' => $vendor->id,
            'kategori_menu_id' => null,
            'nama_menu' => 'Menu Kelola Pesanan',
            'deskripsi' => 'Menu uji',
            'harga' => 17000,
            'is_available' => true,
        ]);

        $guestPaid = User::create([
            'name' => 'Customer Bayar',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $paidOrder = Pesanan::create([
            'user_id' => $guestPaid->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Bayar',
            'total' => 34000,
            'status_pesanan' => 'diproses',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $paidOrder->id,
            'menu_id' => $menu->id,
            'jumlah' => 2,
            'harga' => 17000,
            'subtotal' => 34000,
        ]);

        Payment::create([
            'pesanan_id' => $paidOrder->id,
            'gross_amount' => 34000,
            'status' => 'settlement',
            'payment_type' => 'qris',
        ]);

        $guestUnpaid = User::create([
            'name' => 'Customer Belum Bayar',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $unpaidOrder = Pesanan::create([
            'user_id' => $guestUnpaid->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Belum Bayar',
            'total' => 17000,
            'status_pesanan' => 'pending',
        ]);

        Payment::create([
            'pesanan_id' => $unpaidOrder->id,
            'gross_amount' => 17000,
            'status' => 'pending',
            'payment_type' => 'qris',
        ]);

        $response = $this->actingAs($vendorUser)->get('/dashboard/pesanan');

        $response->assertOk();
        $response->assertSee('Kelola Pesanan');
        $response->assertSee('Customer Bayar');
        $response->assertDontSee('Customer Belum Bayar');
        $response->assertSee('Selesaikan');
    }

    public function test_manage_orders_page_filters_by_selesai_status(): void
    {
        $vendorUser = $this->createVendorUser('vendor-orders-filter@kantinkita.id', 'Vendor Orders Filter');
        $vendor = $vendorUser->vendor;

        foreach ([
            ['nama' => 'Customer Diproses', 'status' => 'diproses'],
            ['nama' => 'Customer Selesai', 'status' => 'selesai'],
        ] as $seed) {
            $guest = User::create([
                'name' => $seed['nama'],
                'email' => null,
                'password' => null,
                'role' => 'guest',
            ]);
            $order = Pesanan::create([
                'user_id' => $guest->id,
                'vendor_id' => $vendor->id,
                'nama_customer' => $seed['nama'],
                'total' => 20000,
                'status_pesanan' => $seed['status'],
            ]);
            Payment::create([
                'pesanan_id' => $order->id,
                'gross_amount' => 20000,
                'status' => 'settlement',
                'payment_type' => 'qris',
            ]);
        }

        $response = $this->actingAs($vendorUser)->get('/dashboard/pesanan?status=selesai');

        $response->assertOk();
        $response->assertSee('Customer Selesai');
        $response->assertDontSee('Customer Diproses');
    }

    public function test_mark_as_done_from_manage_orders_redirects_back_with_success(): void
    {
        $vendorUser = $this->createVendorUser('vendor-orders-done@kantinkita.id', 'Vendor Orders Done');
        $vendor = $vendorUser->vendor;

        $guest = User::create([
            'name' => 'Customer Selesaikan',
            'email' => null,
            'password' => null,
            'role' => 'guest',
        ]);

        $pesanan = Pesanan::create([
            'user_id' => $guest->id,
            'vendor_id' => $vendor->id,
            'nama_customer' => 'Customer Selesaikan',
            'total' => 21000,
            'status_pesanan' => 'diproses',
        ]);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'gross_amount' => 21000,
            'status' => 'settlement',
            'payment_type' => 'qris',
        ]);

        $response = $this->actingAs($vendorUser)
            ->from('/dashboard/pesanan')
            ->post(route('dashboard.orders.complete', ['pesanan' => $pesanan->id]));

        $response->assertRedirect('/dashboard/pesanan');
        $response->assertSessionHas('orderSuccess');

        $this->assertDatabaseHas('pesanans', [
            'id' => $pesanan->id,
            'status_pesanan' => 'selesai',
        ]);
    }

    private function createVendorUser(string $email, string $vendorName, bool $isOpen = true): User
    {
        $user = User::create([
            'name' => $vendorName,
            'email' => $email,
            'password' => 'password',
            'role' => 'vendor',
        ]);

        Vendor::create([
            'user_id' => $user->id,
            'nama_vendor' => $vendorName,
            'deskripsi' => 'Deskripsi ' . $vendorName,
            'lokasi' => 'Gedung A',
            'kategori' => 'Indonesia',
            'rating' => 4.8,
            'is_open' => $isOpen,
        ]);

        return $user;
    }
}
