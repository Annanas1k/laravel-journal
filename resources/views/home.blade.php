@extends('layouts.app')

@section('title', 'Acasă')

@section('content')
<div style="text-align:center; padding: 3rem 1rem;">
    <h1 style="font-size:2.2rem; color:#6b4f3a; margin-bottom:1rem;">
        Bine ai venit la Jurnalul Tău Personal
    </h1>
    <p style="font-size:1.1rem; color:#7a6050; max-width:500px; margin:0 auto 2rem;">
        Un loc liniștit unde îți poți nota gândurile, amintirile și emoțiile zilnice.
    </p>
    @auth
        <a href="{{ route('entries.index') }}" class="btn btn-primary">Mergi la jurnal</a>
    @else
        <a href="{{ route('register') }}" class="btn btn-primary" style="margin-right:1rem;">Creează cont</a>
        <a href="{{ route('login') }}" class="btn btn-secondary">Autentifică-te</a>
    @endauth
</div>
@endsection