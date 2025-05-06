<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class OtpVerification extends Component
{
    public $otp;

    public function mount()
    {
        // Pastikan data OTP ada di session
        if (!Session::has('otp_user_data')) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }
    }

    public function verifyOtp()
    {
        // Ambil data OTP dari session
        $otpData = session('otp_user_data');

        // Validasi OTP yang dimasukkan oleh pengguna
        if ($this->otp == $otpData['otp'] && now()->lessThan($otpData['otp_expires_at'])) {
            // OTP valid, lakukan registrasi dan login otomatis
            // Buat pengguna baru
            $user = \App\Models\User::create([
                'name' => $otpData['name'],
                'email' => $otpData['email'],
                'password' => $otpData['password'],
            ]);

            // Login pengguna
            Auth::login($user);

            // Hapus data OTP dari session setelah verifikasi
            session()->forget('otp_user_data');

            return redirect()->route('landing')->with('success', 'Registrasi berhasil, selamat datang!');
        } else {
            // OTP salah atau sudah kadaluarsa
            session()->flash('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }
    }

    public function render()
    {
        return view('livewire.auth.otp-verification');
    }
}