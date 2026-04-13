<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Login - Sistem Payroll')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function authenticate()
    {
        // Validasi input
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            session()->regenerate();
            
            // Redirect ke halaman dashboard (sementara kita arahkan ke '/' dulu)
            return redirect()->intended('/');
        }

        // Jika gagal, kembalikan pesan error
        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}