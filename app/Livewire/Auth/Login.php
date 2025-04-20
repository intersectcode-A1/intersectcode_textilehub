<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('success', 'Login berhasil!');
            if (Auth::user()->role == 'admin') {
                return redirect()->to('/dashboard');
            }
            return redirect()->to('/landing');
        } else {
            session()->flash('error', 'Email atau password salah.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}