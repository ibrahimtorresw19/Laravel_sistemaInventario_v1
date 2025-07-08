<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Mi Aplicación</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --google-color: #DB4437;
            --text-color: #111827;
            --text-secondary: #4b5563;
            --border-color: #d1d5db;
            --bg-color: #f9fafb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.5;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-color: #f3f4f6;
        }

        .auth-card {
            width: 100%;
            max-width: 28rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin: 1rem;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .auth-link {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: var(--primary-hover);
        }

        .auth-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .form-input {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: var(--text-color);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input::placeholder {
            color: #6b7280;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .btn-primary {
            width: 100%;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem 1rem;
            background: transparent;
            color: var(--google-color);
            border: 2px solid var(--google-color);
            border-radius: 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-google i {
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .btn-google:hover {
            background: var(--google-color);
            color: white;
            box-shadow: 0 2px 10px rgba(219, 68, 55, 0.3);
        }

        .separator {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .separator::before,
        .separator::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .separator::before {
            margin-right: 0.5rem;
        }

        .separator::after {
            margin-left: 0.5rem;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem;
            }
            
            .auth-title {
                font-size: 1.5rem;
            }
            
            .btn-google {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Crear una cuenta</h1>
                <p class="auth-subtitle">
                    ¿Ya tienes una cuenta? 
                    <a href="#" class="auth-link">Inicia sesión</a>
                </p>
            </div>

            <form class="auth-form" action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nombre completo</label>
                    <input type="text" name="name" id="name" required
                           class="form-input"
                           placeholder="Tu nombre">
                    @if($errors->has('name'))
                        <span class="error-message">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" required
                           class="form-input"
                           placeholder="tu@email.com">
                    @if($errors->has('email'))
                        <span class="error-message">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">Nombre de usuario</label>
                    <input type="text" name="username" id="username" required
                           class="form-input"
                           placeholder="nombredeusuario">
                    @if($errors->has('username'))
                        <span class="error-message">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" required
                           class="form-input"
                           placeholder="••••••••">
                    @if($errors->has('password'))
                        <span class="error-message">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-input"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary">
                    Registrarse
                </button>

                <div class="separator">o continúa con</div>

                <a href="{{ url('/auth/google') }}" class="btn-google">
                    <i class="fab fa-google"></i>
                    Google
                </a>
            </form>
        </div>
    </div>
</body>
</html>