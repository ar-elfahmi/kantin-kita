<?php

namespace Tests\Feature;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
