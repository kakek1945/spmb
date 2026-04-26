<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SpmbFrontendTest extends TestCase
{
    protected string $pathSettingsCacheKey = 'spmb.path_settings';
    protected string $registrationsCacheKey = 'spmb.registrations';
    protected string $adminCredentialsCacheKey = 'spmb.admin_credentials';

    protected function setUp(): void
    {
        parent::setUp();

        Cache::forget($this->pathSettingsCacheKey);
        Cache::forget($this->registrationsCacheKey);
        Cache::forget($this->adminCredentialsCacheKey);
    }

    public function test_primary_routes_render_successfully(): void
    {
        $this->get('/')->assertOk();
        $this->get('/daftar')->assertOk();
        $this->get('/daftar/sukses/SPMB-2026-DOM-0001')->assertOk();
        $this->get('/admin/login')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/pendaftar')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/pendaftar/1')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/kapasitas')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/laporan')->assertOk();
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/password')->assertOk();
    }

    public function test_landing_page_contains_cta_and_paths(): void
    {
        $this->get('/')
            ->assertSee('Daftar Sekarang')
            ->assertSee('Lihat Informasi Jalur')
            ->assertSee('Domisili')
            ->assertSee('Afirmasi')
            ->assertSee('Prestasi');
    }

    public function test_registration_form_contains_required_and_conditional_fields(): void
    {
        $this->get('/daftar')
            ->assertSee('Pilih jalur pendaftaran terlebih dahulu')
            ->assertSee('Nama lengkap calon murid')
            ->assertSee('Nomor HP orang tua/wali')
            ->assertSee('Kelurahan atau desa domisili')
            ->assertSee('Jenis afirmasi')
            ->assertSee('Nama lomba atau kompetisi');
    }

    public function test_dashboard_contains_stats_and_table_content(): void
    {
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin')
            ->assertSee('Total Pendaftar')
            ->assertSee('Kapasitas Total')
            ->assertSee('Kuota dan keterisian')
            ->assertSee('Domisili');
    }

    public function test_mock_filters_change_the_registrant_listing(): void
    {
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/pendaftar?path=AFR')
            ->assertSee('Mira Azzahra')
            ->assertDontSee('Nadia Putri Maheswari');
    }

    public function test_registration_submission_redirects_to_success_page(): void
    {
        $response = $this->post('/daftar', [
            'full_name' => 'Calon Murid Demo',
            'nisn' => '1234567890',
            'birth_place' => 'Jakarta',
            'birth_date' => '2014-01-10',
            'gender' => 'L',
            'address' => 'Jl. Uji Frontend No. 1',
            'previous_school' => 'SDN Demo 01',
            'parent_name' => 'Orang Tua Demo',
            'parent_phone' => '081234567890',
            'path_code' => 'DOM',
            'village' => 'Kelurahan Demo',
            'district' => 'Kecamatan Demo',
        ]);

        $response->assertRedirect();
        $this->followRedirects($response)
            ->assertSee('Nomor pendaftaran')
            ->assertSee('Valid Prapendaftaran')
            ->assertSee('Calon Murid Demo');
    }

    public function test_registration_rejects_duplicate_nisn(): void
    {
        $response = $this->from('/daftar')->post('/daftar', [
            'full_name' => 'Murid Duplikat',
            'nisn' => '0068123456',
            'birth_place' => 'Jakarta',
            'birth_date' => '2014-01-10',
            'gender' => 'L',
            'address' => 'Jl. Uji Frontend No. 2',
            'previous_school' => 'SDN Demo 02',
            'parent_name' => 'Orang Tua Demo',
            'parent_phone' => '081234567891',
            'path_code' => 'DOM',
            'village' => 'Kelurahan Demo',
            'district' => 'Kecamatan Demo',
        ]);

        $response->assertRedirect('/daftar');
        $response->assertSessionHasErrors('nisn');
    }

    public function test_registration_requires_path_selection(): void
    {
        $response = $this->from('/daftar')->post('/daftar', [
            'full_name' => 'Tanpa Jalur',
            'nisn' => '1234509876',
            'birth_place' => 'Jakarta',
            'birth_date' => '2014-01-10',
            'gender' => 'L',
            'address' => 'Jl. Uji Frontend No. 3',
            'previous_school' => 'SDN Demo 03',
            'parent_name' => 'Orang Tua Demo',
            'parent_phone' => '081234567892',
        ]);

        $response->assertRedirect('/daftar');
        $response->assertSessionHasErrors('path_code');
    }

    public function test_capacity_update_is_persisted(): void
    {
        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->post('/admin/kapasitas', [
            'paths' => [
                'DOM' => [
                    'capacity' => 15,
                    'is_active' => '1',
                    'close_when_full' => '1',
                ],
                'AFR' => [
                    'capacity' => 6,
                    'is_active' => '1',
                    'close_when_full' => '1',
                ],
                'PRS' => [
                    'capacity' => 4,
                    'is_active' => '1',
                    'close_when_full' => '1',
                ],
            ],
        ])->assertRedirect('/admin/kapasitas');

        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin/kapasitas')
            ->assertSee('value="15"', false);

        $this->withSession(['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')])->get('/admin')
            ->assertSee('8 / 15');
    }

    public function test_admin_can_create_update_and_delete_registrant(): void
    {
        $session = ['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')];

        $createResponse = $this->withSession($session)->post('/admin/pendaftar', [
            'full_name' => 'Calon Admin Baru',
            'nisn' => '1231231231',
            'birth_place' => 'Selatpanjang',
            'birth_date' => '2014-02-10',
            'gender' => 'L',
            'address' => 'Jl. Baru No. 10',
            'previous_school' => 'SDN Baru 01',
            'parent_name' => 'Bapak Baru',
            'parent_phone' => '081234567899',
            'email' => 'baru@example.test',
            'path_code' => 'DOM',
            'status' => 'valid',
            'village' => 'Merbau',
            'district' => 'Merbau',
        ]);

        $createResponse->assertRedirect();

        $this->withSession($session)->get('/admin/pendaftar')
            ->assertSee('Calon Admin Baru');

        $this->withSession($session)->put('/admin/pendaftar/17', [
            'full_name' => 'Calon Admin Update',
            'nisn' => '1231231231',
            'birth_place' => 'Selatpanjang',
            'birth_date' => '2014-02-10',
            'gender' => 'L',
            'address' => 'Jl. Baru No. 11',
            'previous_school' => 'SDN Baru 01',
            'parent_name' => 'Bapak Baru',
            'parent_phone' => '081234567899',
            'email' => 'baru@example.test',
            'path_code' => 'DOM',
            'status' => 'valid',
            'village' => 'Merbau',
            'district' => 'Merbau',
        ])->assertRedirect('/admin/pendaftar/17');

        $this->withSession($session)->delete('/admin/pendaftar/17')
            ->assertRedirect('/admin/pendaftar');

        $this->withSession($session)->get('/admin/pendaftar')
            ->assertDontSee('Calon Admin Update');
    }

    public function test_admin_can_change_password(): void
    {
        $session = ['admin_authenticated' => true, 'admin_email' => config('spmb.admin.email')];

        $this->withSession($session)->put('/admin/password', [
            'current_password' => 'Admin123!',
            'password' => 'Admin45678!',
            'password_confirmation' => 'Admin45678!',
        ])->assertRedirect('/admin/password');

        $this->post('/admin/login', [
            'email' => config('spmb.admin.email'),
            'password' => 'Admin45678!',
        ])->assertRedirect('/admin');
    }
}
