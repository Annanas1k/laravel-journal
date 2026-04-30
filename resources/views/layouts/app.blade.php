<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jurnal Personal')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            background-color: #f5f0eb;
            color: #3d3229;
            min-height: 100vh;
        }

        /* ===== NAVBAR ===== */
        nav {
            background-color: #6b4f3a;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            color: #f5f0eb;
            font-size: 1.4rem;
            font-weight: bold;
            text-decoration: none;
        }

        nav .nav-links a {
            color: #e8d9cc;
            text-decoration: none;
            margin-left: 1.5rem;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        nav .nav-links a:hover {
            color: #fff;
        }

        nav .nav-links form {
            display: inline;
        }

        nav .nav-links button {
            background: none;
            border: 1px solid #e8d9cc;
            color: #e8d9cc;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-left: 1.5rem;
            transition: all 0.2s;
        }

        nav .nav-links button:hover {
            background-color: #e8d9cc;
            color: #6b4f3a;
        }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 860px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* ===== MESAJE ===== */
        .alert {
            padding: 0.85rem 1.2rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #2d6a3f;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* ===== CARD ===== */
        .card {
            background: #fff;
            border-radius: 8px;
            padding: 1.8rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 1.2rem;
        }

        /* ===== BUTOANE ===== */
        .btn {
            display: inline-block;
            padding: 0.55rem 1.2rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
        }

        .btn:hover { opacity: 0.85; }

        .btn-primary {
            background-color: #6b4f3a;
            color: #fff;
        }

        .btn-secondary {
            background-color: #9e7b65;
            color: #fff;
        }

        .btn-danger {
            background-color: #c0392b;
            color: #fff;
        }

        .btn-sm {
            padding: 0.35rem 0.8rem;
            font-size: 0.82rem;
        }

        /* ===== FORMULARE ===== */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: bold;
            font-size: 0.9rem;
            color: #5a3e2b;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1px solid #c9b8a8;
            border-radius: 5px;
            font-size: 0.95rem;
            font-family: inherit;
            background-color: #fdfaf7;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #6b4f3a;
        }

        .form-group .error-msg {
            color: #c0392b;
            font-size: 0.82rem;
            margin-top: 0.3rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 140px;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 2rem;
            color: #9e8878;
            font-size: 0.85rem;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="logo">📔 Jurnalul Meu</a>
    <div class="nav-links">
        @auth
            <a href="{{ route('entries.index') }}">Intrări</a>
            <a href="{{ route('entries.create') }}">+ Adaugă</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Deconectare</button>
            </form>
        @else
            <a href="{{ route('login') }}">Autentificare</a>
            <a href="{{ route('register') }}">Înregistrare</a>
        @endauth
    </div>
</nav>

<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="list-style:none;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<footer>
    Jurnal Personal &copy; {{ date('Y') }}
</footer>

</body>
</html>