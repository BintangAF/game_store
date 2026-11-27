<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Kolom "login" boleh email atau username
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // cek apakah user dengan username atau email tersebut ada
        // dan jika ada, ambil password nya
        if (
            $ori_password = DB::table('users')
            ->where($field, $data['login'])
            ->value('password')
        ) {
            // cek kecocokan hash password inputan dan password dari database
            if (Hash::check($data['password'], $ori_password)) {
                // jika cocok ambil role_id nya
                $role_id = DB::table('users')->where($field, $data['login'])->value('role_id');

                if ($role_id == 1) {
                    return back()->withErrors([
                        'login' => 'Email/username atau password salah',
                    ])->onlyInput('login');
                }
            }
        }

        if (
            Auth::attempt(
                [
                    $field => $data['login'],
                    'password' => $data['password'],
                ],
                $request->boolean('remember')
            )
        ) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        // jika Auth::attempt gagal (email / password salah)
        return back()->withErrors(['login' => 'Email/username atau password salah'])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:40', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // di-hash otomatis oleh cast 'hashed'
            'role_id' => 2,                  // 2 = user (lihat RoleSeeder)
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Akun berhasil dibuat. Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
