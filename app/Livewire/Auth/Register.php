<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation, $otp, $step = 1, $generatedOtp;

    public function register()
    {
        if ($this->password !== $this->password_confirmation) {
            return session()->flash('error', 'Password dan konfirmasi password tidak cocok.');
        }
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $this->generatedOtp = rand(100000, 999999);

        session([
            'otp_user_data' => [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'otp' => $this->generatedOtp,
                'otp_expires_at' => now()->addMinutes(5),
            ]
        ]);

        Mail::raw("Kode OTP kamu adalah: {$this->generatedOtp}", function ($message) {
            $message->to($this->email)
                ->subject('Kode OTP Registrasi');
        });

        $this->step = 2;
        session()->flash('success', 'Registrasi berhasil! Cek email Anda untuk kode OTP.');
    }

    public function verifyOtp()
    {
        $otpData = session('otp_user_data');

        if (!$otpData || now()->gt($otpData['otp_expires_at'])) {
            session()->flash('error', 'OTP kadaluarsa. Silakan daftar ulang.');
            return;
        }

        if ($this->otp == $otpData['otp']) {
            User::create([
                'name' => $otpData['name'],
                'email' => $otpData['email'],
                'password' => $otpData['password'],
            ]);

            session()->forget('otp_user_data');

            return redirect()->to('/login');
        } else {
            session()->flash('error', 'OTP tidak sesuai.');
        }
    }

    public function resendOtp()
    {
        $otpData = session('otp_user_data');

        if (!$otpData) {
            session()->flash('error', 'Data registrasi tidak ditemukan. Silakan daftar ulang.');
            return;
        }

        $newOtp = rand(100000, 999999);

        session([
            'otp_user_data' => [
                'name' => $otpData['name'],
                'email' => $otpData['email'],
                'password' => $otpData['password'],
                'otp' => $newOtp,
                'otp_expires_at' => now()->addMinutes(5),
            ]
        ]);

        Mail::raw("Kode OTP kamu adalah: {$newOtp}", function ($message) use ($otpData) {
            $message->to($otpData['email'])
                ->subject('Kode OTP Registrasi - Kirim Ulang');
        });

        $this->otp = '';
        session()->flash('resent', 'Kode OTP berhasil dikirim ulang ke email Anda.');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
