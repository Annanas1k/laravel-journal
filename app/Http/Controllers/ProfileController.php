<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Afișează formularul de editare a profilului.
     */
    public function edit()
    {
        // Preluăm userul logat pentru a-i trimite datele către view
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Salvează modificările profilului.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'             => 'required|min:2|max:50',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required', // Parola veche e mereu necesară pentru validare
            'password'         => 'nullable|min:6', // Parola nouă e opțională
        ]);

        // Verificăm dacă parola actuală este corectă
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Parola actuală nu este corectă.']);
        }

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Dacă a completat parola nouă, o actualizăm
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profilul a fost actualizat cu succes!');
    }
}