<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Menampilkan form login autentikasi pustakawan.
     */
    public function showLoginForm(Request $request)
    {
        $lastEmail = $request->cookie('del_last_librarian_email');

        return view('auth.login', compact('lastEmail'));
    }

    /**
     * Memproses autentikasi pustakawan, regenerasi ID sesi (anti-Session Fixation), dan penerbitan cookie.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Alamat email dinas pustakawan wajib diisi.',
            'email.email' => 'Format email yang dimasukkan tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // WAJIB: Regenerasi ID sesi untuk mencegah serangan Session Fixation
            $request->session()->regenerate();

            // Simpan audit state ke dalam sesi server
            session([
                'login_timestamp' => now()->translatedFormat('d M Y, H:i:s') . ' WIB',
                'pustakawan_name' => Auth::user()->name,
            ]);

            // Terbitkan HTTP Cookie aman (HttpOnly secara default pada Laravel) selama 7 hari (10080 menit)
            Cookie::queue('del_last_librarian_email', $request->email, 10080);

            return redirect()->intended(route('buku.index'))
                ->with('success', 'Autentikasi berhasil. Sesi pustakawan telah aktif dan terlindungi.');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Kredensial login tidak valid. Pastikan email dan password pustakawan telah benar.');
    }

    /**
     * Mengakhiri sesi pustakawan dengan aman (invalidasi sesi dan regenerasi token CSRF).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidasi data sesi di server
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk mencegah eksploitasi request lama
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesi server pustakawan telah ditutup dan dihapus dengan aman.');
    }
}

