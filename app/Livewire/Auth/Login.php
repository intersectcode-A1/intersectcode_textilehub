<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required',
    ];

    public function login()
{
    $this->validate();

    if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
        $user = Auth::user();
        session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');  // ⬅️ redirect ke admin dashboard
        } else {
            return redirect()->route('ecatalog.index');    // ⬅️ redirect ke e-catalog
        }
    }

    session()->flash('error', 'Email atau password salah.');
}


    public function render()
    {
        return view('livewire.auth.login');
    }
}
