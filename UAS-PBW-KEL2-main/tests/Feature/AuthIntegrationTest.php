<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthIntegrationTest extends TestCase
{
    use RefreshDatabase; // Reset database setiap kali test berjalan

    // TC-INT01: Integrasi Registrasi dan Penyimpanan Database
    public function test_integration_registration_flow_saves_to_database_and_redirects()
    {
        $response = $this->post('/register', [
            'name' => 'Integration User',
            'email' => 'integration@domain.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Memastikan dialihkan ke /home setelah register
        $response->assertRedirect('/home'); 
        
        // Memastikan data benar-benar terintegrasi masuk ke database MySQL/SQLite
        $this->assertDatabaseHas('users', [
            'email' => 'integration@domain.com',
            'name' => 'Integration User'
        ]);
        
        // Memastikan user langsung terautentikasi (login) setelah register
        $this->assertAuthenticated(); 
    }

    // TC-INT02: Alur Autentikasi dan Otorisasi Sesi
    public function test_integration_login_flow_authenticates_and_creates_session()
    {
        // Setup data awal di database
        $user = User::factory()->create([
            'password' => Hash::make('rahasia123')
        ]);

        // Simulasi hit endpoint login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'rahasia123',
        ]);

        // Verifikasi integrasi state aplikasi berubah
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home');
    }

    // TC-INT03: Pengujian Proteksi Middleware RedirectIfAuthenticated
    public function test_integration_authenticated_user_cannot_access_guest_routes()
    {
        // Setup user yang sudah login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Mencoba mengakses rute guest
        $responseLogin = $this->get('/login');
        $responseRegister = $this->get('/register');

        // Memastikan middleware berfungsi menolak akses dan mengalihkan
        $responseLogin->assertRedirect('/home');
        $responseRegister->assertRedirect('/home');
    }

    // TC-INT04: Integrasi Logout dan Pembersihan Sesi
    public function test_integration_logout_destroys_session_and_redirects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->assertAuthenticatedAs($user);

        // Simulasi hit rute logout
        $response = $this->post('/logout');

        // Memastikan sesi benar-benar hancur
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // TC-INT05: Validasi Respons HTTP dan Manajemen Error
    public function test_integration_invalid_login_returns_validation_errors()
    {
        // Hit endpoint dengan payload kosong
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        // Memastikan aplikasi tidak crash, melainkan mengembalikan error 302 dari validator
        $response->assertStatus(302);
        
        // Memastikan session Laravel menangkap error integrasi untuk field spesifik
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }
}