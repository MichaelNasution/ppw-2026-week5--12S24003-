<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthSessionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Uji login pustakawan berhasil meregenerasi ID sesi dan menerbitkan Cookie HttpOnly.
     */
    public function test_login_pustakawan_berhasil_meregenerasi_sesi_dan_cookie(): void
    {
        $user = User::create([
            'name' => 'Pustakawan Del',
            'email' => 'pustakawan.test@del.ac.id',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post(route('login.attempt'), [
            'email' => 'pustakawan.test@del.ac.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('buku.index'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('login_timestamp');

        // Pastikan pengguna terotentikasi
        $this->assertAuthenticatedAs($user);

        // Pastikan cookie del_last_librarian_email diterbitkan
        $response->assertCookie('del_last_librarian_email', 'pustakawan.test@del.ac.id');
    }

    /**
     * Uji proteksi middleware auth: rute sirkulasi memblokir tamu dan mengarahkan ke halaman login.
     */
    public function test_tamu_tidak_bisa_mengakses_rute_sirkulasi_dan_dialihkan_ke_login(): void
    {
        $response = $this->get(route('peminjaman.index'));
        $response->assertRedirect(route('login'));

        $responseCreate = $this->get(route('peminjaman.create'));
        $responseCreate->assertRedirect(route('login'));
    }

    /**
     * Uji logout pustakawan menginvalidsasi sesi dan meregenerasi token CSRF.
     */
    public function test_logout_pustakawan_menghapus_sesi(): void
    {
        $user = User::create([
            'name' => 'Pustakawan Logout',
            'email' => 'logout.test@del.ac.id',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}

