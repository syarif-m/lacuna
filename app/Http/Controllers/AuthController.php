<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = filter_var($validated['identity'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $credentials = [
            $field => $validated['identity'],
            'password' => $validated['password'],
            'account_status' => 'ACTIVE',
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'identity' => 'Username, email, atau password tidak valid. Pastikan akun Anda aktif.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'ADMIN') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('member.dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                'alpha_dash', 'unique:users,username'
            ],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => $validated['password'],
            'role' => 'MEMBER',
            'account_status' => 'ACTIVE',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('member.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
