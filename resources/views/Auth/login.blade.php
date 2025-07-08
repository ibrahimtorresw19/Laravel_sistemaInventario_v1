@extends('index')
@section('content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --error-color: #ef4444;
        --text-color: #374151;
        --light-gray: #f3f4f6;
        --border-color: #e5e7eb;
    }

    .login-container {
        max-width: 400px;
        margin: 5rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .login-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-color);
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: border-color 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .btn-login {
        width: 100%;
        padding: 0.75rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-login:hover {
        background-color: var(--primary-hover);
    }

    .forgot-password {
        display: block;
        text-align: right;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--primary-color);
        text-decoration: none;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: #9ca3af;
        font-size: 0.75rem;
    }

    .divider::before, .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid var(--border-color);
    }

    .divider::before {
        margin-right: 0.5rem;
    }

    .divider::after {
        margin-left: 0.5rem;
    }

    .register-link {
        text-align: center;
        font-size: 0.875rem;
        color: var(--text-color);
    }

    .register-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    /* Error messages */
    .error-message {
        color: var(--error-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Responsive adjustments */
    @media (max-width: 480px) {
        .login-container {
            margin: 2rem 1rem;
            padding: 1.5rem;
        }
    }
</style>

<div class="login-container">
    <h1 class="login-title">Iniciar Sesión</h1>



    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-input"
                placeholder="tu@email.com"
                required
               
            >

        </div>

        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input"
                placeholder="••••••••"
                required
            >

        </div>

        <button type="submit" class="btn-login">Iniciar Sesión</button>

        <div class="divider">o</div>


    </form>
</div>
@endsection
