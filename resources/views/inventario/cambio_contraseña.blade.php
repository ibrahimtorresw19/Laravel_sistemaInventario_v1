@extends('principal')
@section('content')

@section('styles')
<style>
    /* Contenedor principal */
    .password-change-container {
        max-width: 500px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Título */
    .password-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.75rem;
        text-align: center;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    /* Campos del formulario */
    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #334155;
        font-size: 0.95rem;
    }

    .input-container {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.3s;
        font-size: 0.95rem;
        padding-right: 40px;
    }

    .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    /* Icono para mostrar/ocultar contraseña */
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #64748b;
        transition: color 0.2s;
    }

    .toggle-password:hover {
        color: #334155;
    }

    /* Botón */
    .submit-btn {
        width: 100%;
        padding: 0.85rem;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 0.5rem;
    }

    .submit-btn:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    /* Mensajes de error */
    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }

    /* Notificaciones */
    .notification {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.75rem;
        font-weight: 500;
        animation: fadeIn 0.3s ease-out;
    }

    .notification.success {
        background-color: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .notification.error {
        background-color: #fef2f2;
        color: #b91c1c;
        border-left: 4px solid #ef4444;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Texto de ayuda */
    .help-text {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 0.5rem;
        display: block;
    }

    /* Ícono del botón */
    .btn-icon {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="password-change-container">
    <h1 class="password-title">
        <i class="fas fa-key btn-icon"></i>Cambiar Contraseña
    </h1>

    @if(session('success'))
        <div class="notification success">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="notification error">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <!-- Contraseña Actual -->
        <div class="form-group">
            <label for="current_password" class="form-label">Contraseña Actual</label>
            <div class="input-container">
                <input type="password" id="current_password" name="current_password" 
                       class="form-control" required autocomplete="current-password">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('current_password', this)"></i>
            </div>
            @error('current_password')
                <span class="error-message">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </span>
            @enderror
        </div>

        <!-- Nueva Contraseña -->
        <div class="form-group">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <div class="input-container">
                <input type="password" id="password" name="password" 
                       class="form-control" required autocomplete="new-password">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
            </div>
            @error('password')
                <span class="error-message">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </span>
            @enderror
            <span class="help-text">Mínimo 8 caracteres, diferente a la actual</span>
        </div>

        <!-- Confirmar Contraseña -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <div class="input-container">
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="form-control" required autocomplete="new-password">
                <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
            </div>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="submit-btn">
            <i class="fas fa-save btn-icon"></i>Actualizar Contraseña
        </button>
    </form>
</div>

<script>
    // Función para mostrar/ocultar contraseña
    function togglePassword(fieldId, iconElement) {
        const field = document.getElementById(fieldId);
        
        if (field.type === 'password') {
            field.type = 'text';
            iconElement.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            iconElement.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Validación en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
        
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
        
        // Auto cerrar notificaciones después de 5 segundos
        setTimeout(() => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            });
        }, 5000);
    });
</script>

<!-- Incluir FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection