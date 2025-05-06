<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation, $otp, $step = 1, $generatedOtp;

    public function submitRegistration()
    {
        if ($this->password !== $this->password_confirmation) {
            return session()->flash('error', 'Password dan konfirmasi password tidak cocok.');
        }
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Generate OTP
        $this->generatedOtp = rand(100000, 999999);

        // Simpan ke session sementara (atau ke DB)
        session([
            'otp_user_data' => [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'otp' => $this->generatedOtp,
                'otp_expires_at' => now()->addMinutes(5),
            ]
        ]);

        // Kirim OTP via Email
        Mail::raw("Kode OTP kamu adalah: {$this->generatedOtp}", function ($message) {
            $message->to($this->email)
                    ->subject('Kode OTP Registrasi');
        });

        $this->step = 2; // Masuk ke step verifikasi OTP
        return session()->flash('success', 'Registrasi berhasil! Cek email Anda untuk kode OTP.');
        // return redirect()->to('/register/verify-otp');
    }

    public function verifyOtp()
    {
        $otpData = session('otp_user_data');

        if (!$otpData || now()->gt($otpData['otp_expires_at'])) {
            return session()->flash('error', 'OTP kadaluarsa. Silakan daftar ulang.');
        }

        if ($this->otp == $otpData['otp']) {
            User::create([
                'name' => $otpData['name'],
                'email' => $otpData['email'],
                'password' => $otpData['password'],
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            session()->forget('otp_user_data');

            return redirect()->to('/login');
        } else {
            session()->flash('error', 'OTP tidak sesuai.');
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}