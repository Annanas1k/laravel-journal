@extends('layouts.app')

@section('title', 'Editează profilul')

@section('content')
<div style="max-width:480px; margin:0 auto;">
    <div class="card">
        <h2 style="color:#6b4f3a; margin-bottom:1.5rem;">Editează profilul</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nume</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <hr style="margin:1.5rem 0; border:none; border-top:1px solid #e8d9cc;">
            
            <div class="form-group">
                <label>Parola actuală</label>
                <input type="password" name="current_password" placeholder="Introdu parola actuală pentru orice modificare">
                @error('current_password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label>Parolă nouă (opțional)</label>
                <input type="password" name="password" placeholder="Minim 6 caractere dacă vrei să o schimbi">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div style="display:flex; gap:0.8rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Salvează</button>
                <a href="{{ route('entries.index') }}" class="btn btn-secondary">Anulează</a>
            </div>
        </form>
    </div>
</div>
@endsection