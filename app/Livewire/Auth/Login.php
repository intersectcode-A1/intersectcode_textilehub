<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    // Aturan validasi input
    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        // Coba login user
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
           if (Auth::user()->role === 'admin')
            return redirect()->intended('/dashboard');
        else
            return redirect()->intended('/ecatalog');

             // // Cek apakah user adalah admin
            // if ($user->role === 'admin') {
            //     session()->flash('message', 'Login berhasil sebagai admin.');
            //     return redirect()->route('dashboard');
            // }
            // Jika bukan admin, logout dan tolak akses
            // Auth::logout();
            // session()->invalidate();
            // session()->regenerateToken();

            // session()->flash('error', 'Akses ditolak. Anda bukan admin.');
            // return;
        }

        // Jika kombinasi email/password salah
        session()->flash('error', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
