@extends('layouts.app')

@section('title', 'Înregistrare')

@section('content')
<div style="max-width:420px; margin:0 auto;">
    <div class="card">
        <h2 style="margin-bottom:1.5rem; color:#6b4f3a;">Creează cont nou</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nume</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Numele tău">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@exemplu.com">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Parolă</label>
                <input type="password" name="password" placeholder="Minim 6 caractere">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Confirmă parola</label>
                <input type="password" name="password_confirmation" placeholder="Repetă parola">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Înregistrează-te</button>
        </form>

        <p style="margin-top:1.2rem; text-align:center; font-size:0.9rem;">
            Ai deja cont? <a href="{{ route('login') }}" style="color:#6b4f3a;">Autentifică-te</a>
        </p>
    </div>
</div>
@endsection