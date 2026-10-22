<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (session('token')) {
            return redirect()->route('home');
        }

        return view('login');
    }

    /**
     * Inicia sesión: verifica credenciales, genera token y lo guarda en sesión.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ])->onlyInput('email');
        }

        $token = Str::random(60);

        session([
            'token' => $token,
            'name' => $user->name,
        ]);

        return redirect()->route('home');
    }

    /**
     * Cierra sesión: invalida la sesión y redirige al login.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
