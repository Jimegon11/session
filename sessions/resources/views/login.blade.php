<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Iniciar sesión — {{ config('app.name', 'Laravel') }}</title>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

                :root {
                    --bg: #FDFDFC;
                    --card-bg: #ffffff;
                    --text: #1b1b18;
                    --text-muted: #706f6c;
                    --border: #e3e3e0;
                    --border-hover: #19140035;
                    --accent: #f53003;
                    --accent-hover: #cc2500;
                    --input-bg: #f9f9f8;
                    --shadow: 0 1px 3px rgba(0,0,0,0.10), 0 1px 2px rgba(0,0,0,0.06);
                    --font: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                }

                @media (prefers-color-scheme: dark) {
                    :root {
                        --bg: #0a0a0a;
                        --card-bg: #161615;
                        --text: #EDEDEC;
                        --text-muted: #A1A09A;
                        --border: #3E3E3A;
                        --border-hover: #62605b;
                        --accent: #FF4433;
                        --accent-hover: #ff6655;
                        --input-bg: #1b1b18;
                        --shadow: 0 1px 3px rgba(0,0,0,0.40), 0 1px 2px rgba(0,0,0,0.30);
                    }
                }

                body {
                    font-family: var(--font);
                    background-color: var(--bg);
                    color: var(--text);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 1.5rem;
                    -webkit-font-smoothing: antialiased;
                }

                .card {
                    background-color: var(--card-bg);
                    border: 1px solid var(--border);
                    border-radius: 0.5rem;
                    box-shadow: var(--shadow);
                    padding: 2.5rem 2rem;
                    width: 100%;
                    max-width: 380px;
                }

                .card-header {
                    margin-bottom: 2rem;
                }

                .card-header h1 {
                    font-size: 1.25rem;
                    font-weight: 600;
                    margin-bottom: 0.25rem;
                }

                .card-header p {
                    font-size: 0.875rem;
                    color: var(--text-muted);
                }

                .form-group {
                    margin-bottom: 1.25rem;
                }

                label {
                    display: block;
                    font-size: 0.8125rem;
                    font-weight: 500;
                    margin-bottom: 0.375rem;
                }

                input[type="email"],
                input[type="password"] {
                    width: 100%;
                    background-color: var(--input-bg);
                    border: 1px solid var(--border);
                    border-radius: 0.375rem;
                    color: var(--text);
                    font-family: var(--font);
                    font-size: 0.875rem;
                    padding: 0.5rem 0.75rem;
                    outline: none;
                    transition: border-color 0.15s;
                }

                input[type="email"]:focus,
                input[type="password"]:focus {
                    border-color: var(--accent);
                }

                .error-message {
                    font-size: 0.75rem;
                    color: var(--accent);
                    margin-top: 0.375rem;
                }

                .btn-primary {
                    display: block;
                    width: 100%;
                    background-color: #1b1b18;
                    color: #ffffff;
                    border: 1px solid #1b1b18;
                    border-radius: 0.25rem;
                    font-family: var(--font);
                    font-size: 0.875rem;
                    font-weight: 500;
                    padding: 0.5rem 1.25rem;
                    cursor: pointer;
                    transition: background-color 0.15s, border-color 0.15s;
                    margin-top: 1.5rem;
                }

                .btn-primary:hover {
                    background-color: #000;
                    border-color: #000;
                }

                @media (prefers-color-scheme: dark) {
                    .btn-primary {
                        background-color: #eeeeec;
                        color: #1C1C1A;
                        border-color: #eeeeec;
                    }
                    .btn-primary:hover {
                        background-color: #ffffff;
                        border-color: #ffffff;
                    }
                }

                .back-link {
                    display: block;
                    text-align: center;
                    font-size: 0.8125rem;
                    color: var(--text-muted);
                    margin-top: 1.25rem;
                    text-decoration: none;
                    transition: color 0.15s;
                }

                .back-link:hover {
                    color: var(--text);
                }

                .alert-error {
                    background-color: #fff2f2;
                    border: 1px solid #f53003;
                    border-radius: 0.375rem;
                    color: #f53003;
                    font-size: 0.8125rem;
                    padding: 0.75rem 1rem;
                    margin-bottom: 1.25rem;
                }

                @media (prefers-color-scheme: dark) {
                    .alert-error {
                        background-color: #1D0002;
                        border-color: #FF4433;
                        color: #FF4433;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <div class="card">
            <div class="card-header">
                <h1>Iniciar sesión</h1>
                <p>Introduce tus credenciales para continuar</p>
            </div>

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="tu@correo.com"
                    >
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button id="btn-login" type="submit" class="btn-primary">
                    Entrar
                </button>
            </form>

            <a href="{{ route('home') }}" class="back-link">
                ← Volver al inicio
            </a>
        </div>
    </body>
</html>
