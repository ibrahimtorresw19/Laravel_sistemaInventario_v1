<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Código</title>
    <style>
        /* Variables de color */
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --error-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f5f7ff;
        }

        /* Contenedor principal */
        .verification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .verification-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
        }

        .verification-card:hover {
            transform: translateY(-5px);
        }

        /* Encabezado */
        .verification-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
        }

        .verification-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            transform: skewY(-3deg);
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .verification-header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .verification-header svg {
            width: 48px;
            height: 48px;
            margin: 1rem 0;
            fill: white;
            opacity: 0.9;
        }

        .verification-header p {
            margin: 0.5rem 0 0;
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Cuerpo */
        .verification-body {
            padding: 2.5rem 2rem 1.5rem;
            position: relative;
            z-index: 2;
        }

        /* Alertas */
        .alert-message {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-message svg {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }

        .alert-message.success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-message.error {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }

        /* Formulario */
        .verification-form {
            margin-top: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            fill: var(--gray-color);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-group input::placeholder {
            color: #adb5bd;
            letter-spacing: 1px;
        }

        .error-text {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Botones */
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .form-actions button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .form-actions button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .form-actions button svg {
            width: 18px;
            height: 18px;
            margin-left: 0.5rem;
            fill: white;
        }

        .resend-link {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .resend-link svg {
            width: 16px;
            height: 16px;
            margin-right: 0.5rem;
            fill: var(--primary-color);
        }

        /* Pie de tarjeta */
        .verification-footer {
            padding: 1.5rem 2rem;
            background-color: #f8f9fa;
            text-align: center;
            border-top: 1px solid #e9ecef;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .verification-footer svg {
            width: 24px;
            height: 24px;
            margin-bottom: 0.5rem;
            fill: var(--gray-color);
        }

        .verification-footer p {
            margin: 0;
            color: var(--gray-color);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .verification-container {
                padding: 1rem;
            }

            .verification-header, .verification-body {
                padding: 1.5rem 1.25rem;
            }

            .verification-footer {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    @extends('index')

    @section('content')
    <div class="verification-container">
        <div class="verification-card">
            <!-- Encabezado con gradiente -->
            <div class="verification-header">
                <div class="header-content">
                    <h1>Verificación de Código</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <p>Por favor ingresa el código que enviamos a tu correo</p>
            </div>

            <!-- Cuerpo del formulario -->
            <div class="verification-body">
                <!-- Mensajes de estado -->
                @if(session('message'))
                    <div class="alert-message success">
                        <svg viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('message') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-message error">
                        <svg viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Formulario -->
                <form class="verification-form" action="{{ route('verification.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('verification_email') }}">

                    <!-- Campo de código -->
                    <div class="form-group">
                        <label for="code">Código de Verificación</label>
                        <div class="input-wrapper">
                            <input id="code" type="text" name="code" value="{{ old('code') }}"
                                   required autocomplete="off" autofocus placeholder="••••••">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        @error('code')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="form-actions">
                        <button type="submit">
                            Verificar Código
                            <svg viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <a href="{{ route('verification.resend') }}" class="resend-link">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Reenviar código
                        </a>
                    </div>
                </form>
            </div>

            <!-- Pie de tarjeta -->
            <div class="verification-footer">
                <svg viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p>¿No recibiste el código? Revisa tu carpeta de spam o solicita un nuevo código.</p>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
