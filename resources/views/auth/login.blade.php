@extends('layouts.app')

@section('title', 'Autentificare')

@section('content')
<div style="max-width:420px; margin:0 auto;">
    <div class="card">
        <h2 style="margin-bottom:1.5rem; color:#6b4f3a;">Autentificare</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@exemplu.com">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Parolă</label>
                <input type="password" name="password" placeholder="Parola ta">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Intră în cont</button>
        </form>

        <p style="margin-top:1.2rem; text-align:center; font-size:0.9rem;">
            Nu ai cont? <a href="{{ route('register') }}" style="color:#6b4f3a;">Înregistrează-te</a>
        </p>
    </div>
</div>
@endsection