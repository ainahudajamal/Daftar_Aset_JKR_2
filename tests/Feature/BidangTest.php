<?php

use App\Models\User;
use App\Models\Bidang;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot access bidang routes', function () {
    $this->get(route('admin.bidang.index'))->assertRedirect(route('login'));
    $this->get(route('admin.bidang.create'))->assertRedirect(route('login'));
    $this->post(route('admin.bidang.store'), [])->assertRedirect(route('login'));
});

test('non-admin user cannot access bidang routes', function () {
    $user = User::factory()->create([
        'role' => 'user',
        'username' => 'testuser',
    ]);

    $this->actingAs($user)->get(route('admin.bidang.index'))->assertStatus(403);
    $this->actingAs($user)->get(route('admin.bidang.create'))->assertStatus(403);
});

test('admin can view bidang index', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'username' => 'testadmin',
    ]);
    $bidang = Bidang::create([
        'kod' => 'M01',
        'nama' => 'Mekanikal',
        'keterangan' => 'Sistem Mekanikal',
        'is_active' => true,
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.bidang.index'));

    $response->assertStatus(200);
    $response->assertSee('M01');
    $response->assertSee('Mekanikal');

    // Verify AuditLog entry
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $admin->id,
        'title' => 'Lihat Konfigurasi Bidang',
    ]);
});

test('admin can create bidang', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'username' => 'testadmin',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.bidang.store'), [
        'kod' => 'E01',
        'nama' => 'Elektrikal',
        'keterangan' => 'Sistem Elektrikal',
        'is_active' => 'on',
    ]);

    $response->assertRedirect(route('admin.bidang.index'));
    $response->assertSessionHas('success', 'Kod bidang berjaya ditambah!');

    $this->assertDatabaseHas('bidangs', [
        'kod' => 'E01',
        'nama' => 'Elektrikal',
        'is_active' => true,
        'status' => 'aktif',
    ]);

    // Verify AuditLog entry
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $admin->id,
        'title' => 'Tambah Bidang',
        'description' => 'Bidang baru ditambah - Kod: E01',
    ]);
});

test('admin can edit and update bidang', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'username' => 'testadmin',
    ]);
    $bidang = Bidang::create([
        'kod' => 'E01',
        'nama' => 'Elektrikal',
        'keterangan' => 'Sistem Elektrikal',
        'is_active' => true,
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.bidang.edit', $bidang));
    $response->assertStatus(200);

    $response = $this->actingAs($admin)->put(route('admin.bidang.update', $bidang), [
        'kod' => 'E01_MOD',
        'nama' => 'Elektrikal Modifikasi',
        'keterangan' => 'Keterangan Baru',
    ]);

    $response->assertRedirect(route('admin.bidang.index'));
    $response->assertSessionHas('success', 'Kod bidang berjaya dikemaskini!');

    $this->assertDatabaseHas('bidangs', [
        'id' => $bidang->id,
        'kod' => 'E01_MOD',
        'nama' => 'Elektrikal Modifikasi',
        'is_active' => false,
        'status' => 'tidak_aktif',
    ]);

    // Verify AuditLog entry
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $admin->id,
        'title' => 'Kemaskini Bidang',
        'description' => 'Bidang dikemaskini - Kod: E01_MOD',
    ]);
});

test('admin can delete bidang', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'username' => 'testadmin',
    ]);
    $bidang = Bidang::create([
        'kod' => 'E01',
        'nama' => 'Elektrikal',
        'keterangan' => 'Sistem Elektrikal',
        'is_active' => true,
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.bidang.destroy', $bidang));

    $response->assertRedirect(route('admin.bidang.index'));
    $response->assertSessionHas('success', 'Kod bidang berjaya dipadam!');

    $this->assertDatabaseMissing('bidangs', [
        'id' => $bidang->id,
    ]);

    // Verify AuditLog entry
    $this->assertDatabaseHas('audit_logs', [
        'user_id' => $admin->id,
        'title' => 'Padam Bidang',
        'description' => 'Bidang dipadam - Kod: E01',
    ]);
});
