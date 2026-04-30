<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afișează pagina de înregistrare
    public function showRegister()
    {
        return view('auth.register');
    }

    // Procesează înregistrarea
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:2|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Numele este obligatoriu.',
            'email.required'     => 'Email-ul este obligatoriu.',
            'email.unique'       => 'Acest email este deja folosit.',
            'password.confirmed' => 'Parolele nu coincid.',
            'password.min'       => 'Parola trebuie să aibă minim 6 caractere.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // parola securizată
        ]);

        Auth::login($user);

        return redirect()->route('entries.index')
                         ->with('success', 'Cont creat cu succes! Bine ai venit!');
    }

    // Afișează pagina de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesează autentificarea
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('entries.index')
                             ->with('success', 'Bine ai revenit, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email sau parolă incorectă.',
        ])->withInput($request->only('email'));
    }

    // Deconectare
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Te-ai deconectat cu succes.');
    }
}