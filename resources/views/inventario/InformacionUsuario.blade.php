@extends('principal')
@section('content')

@section('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .avatar-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: white;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        font-size: 3rem;
        font-weight: bold;
        border: 4px solid white;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #3b82f6;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid white;
    }

    .avatar-upload-btn:hover {
        background: #2563eb;
        transform: scale(1.1);
    }

    #avatar-input {
        display: none;
    }

    .profile-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #334155;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .nav-tabs {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }

    .nav-tab {
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        font-weight: 600;
        color: #64748b;
        border-bottom: 3px solid transparent;
    }

    .nav-tab.active {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
    }

    dialog::backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    dialog {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 600px;
        border: none;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease-out;
        z-index: 1000;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1e293b;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }

    .modal-close:hover {
        color: #334155;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-secondary {
        background-color: #e2e8f0;
        color: #334155;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #cbd5e1;
    }

    .info-field {
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background-color: #f8fafc;
        min-height: 42px;
        display: flex;
        align-items: center;
    }

    .text-red-500 {
        color: #ef4444;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .avatar-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        display: none;
    }

    .avatar-error {
        color: #ef4444;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        display: none;
    }

    /* Notificaciones */
    .notification {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    }

    .notification.success {
        background-color: #10b981;
    }

    .notification.error {
        background-color: #ef4444;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Perfil de Usuario</h1>

    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-container">
                <div class="profile-avatar" id="user-avatar" style="background-image: url('{{ $usuario->avatar ? asset('storage/avatars/'.$usuario->avatar) : '' }}')">
                    @if(!$usuario->avatar)
                        {{ strtoupper(substr($usuario->name, 0, 1)) }}
                    @endif
                </div>
                <div class="avatar-loading" id="avatar-loading">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                </div>

                <form id="avatar-form" method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="avatar-input" name="avatar" accept="image/*">
                    <label for="avatar-input" class="avatar-upload-btn">
                        <i class="fas fa-camera"></i>
                    </label>
                </form>
                <div class="avatar-error" id="avatar-error"></div>
            </div>
            <h2 class="text-xl font-bold" id="user-name">{{ $usuario->name }}</h2>
            <p class="opacity-90" id="user-email">{{ $usuario->email }}</p>
        </div>

        <div class="profile-body">
            <div class="nav-tabs">
                <div class="nav-tab active" onclick="changeTab('profile')">Información</div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div id="profile-tab" class="tab-content active">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <div class="info-field">{{ $usuario->name }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="info-field">{{ $usuario->email }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nombre de usuario</label>
                        <div class="info-field">{{ $usuario->username }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado de verificación</label>
                        <div class="info-field">{{ $usuario->is_verified ? 'Verificado' : 'No verificado' }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Miembro desde</label>
                        <div class="info-field">{{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Última actualización</label>
                        <div class="info-field">{{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button class="btn btn-primary" id="edit-profile-btn">Editar Perfil</button>
                    <a href="{{ route('cambioClave.index') }}">
                        <button class="btn bg-gray-200 text-gray-800 hover:bg-gray-300">Cambiar Contraseña</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar perfil -->
<dialog id="editProfileModal">
    <div class="modal-header">
        <h3 class="modal-title">Editar Perfil</h3>
        <button class="modal-close" id="closeModal">&times;</button>
    </div>

    <form id="profile-form" method="POST" action="{{ route('profile.update', $usuario->id) }}">
        @method('PUT')
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" id="modal-name" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="modal-email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" id="modal-username" name="username" class="form-control" value="{{ old('username', $usuario->username) }}" required>
                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelEdit">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</dialog>

<script>
    // Mostrar notificación
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Cambiar foto de perfil
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const errorElement = document.getElementById('avatar-error');
        const loadingElement = document.getElementById('avatar-loading');
        const avatarElement = document.getElementById('user-avatar');
        
        // Resetear mensajes de error
        errorElement.style.display = 'none';
        errorElement.textContent = '';
        
        // Validar el archivo
        if (!file) return;
        
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        const maxSize = 2048 * 1024; // 2MB
        
        if (!validTypes.includes(file.type)) {
            errorElement.textContent = 'Formato no válido. Use JPEG, PNG o GIF.';
            errorElement.style.display = 'block';
            return;
        }
        
        if (file.size > maxSize) {
            errorElement.textContent = 'La imagen es demasiado grande (máx. 2MB)';
            errorElement.style.display = 'block';
            return;
        }
        
        // Mostrar vista previa
        const reader = new FileReader();
        reader.onload = function(e) {
            avatarElement.style.backgroundImage = `url(${e.target.result})`;
            avatarElement.textContent = '';
        }
        reader.readAsDataURL(file);
        
        // Mostrar loader
        loadingElement.style.display = 'flex';
        
        // Crear FormData
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Enviar mediante AJAX
        fetch("{{ route('avatar.update') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Actualizar la imagen con timestamp para evitar caché
                avatarElement.style.backgroundImage = `url(${data.avatar_url}?${new Date().getTime()})`;
                
                // Mostrar notificación de éxito
                showNotification('success', data.message);
            } else {
                throw new Error(data.message || 'Error al actualizar el avatar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Restaurar avatar anterior
            @if($usuario->avatar)
                avatarElement.style.backgroundImage = `url('{{ asset('storage/avatars/'.$usuario->avatar) }}?${new Date().getTime()})`;
            @else
                avatarElement.style.backgroundImage = '';
                avatarElement.textContent = '{{ strtoupper(substr($usuario->name, 0, 1)) }}';
            @endif
            
            // Mostrar error
            errorElement.textContent = error.message || 'Error al subir la imagen';
            errorElement.style.display = 'block';
            
            // Mostrar notificación de error
            showNotification('error', error.message || 'Error al subir la imagen');
        })
        .finally(() => {
            loadingElement.style.display = 'none';
            document.getElementById('avatar-input').value = '';
        });
    });

    // Modal de edición de perfil
    const editProfileModal = document.getElementById('editProfileModal');
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelEditBtn = document.getElementById('cancelEdit');

    // Abrir modal
    editProfileBtn.addEventListener('click', function() {
        editProfileModal.showModal();
    });

    // Cerrar modal con botón X
    closeModalBtn.addEventListener('click', function() {
        editProfileModal.close();
    });

    // Cerrar modal con botón Cancelar
    cancelEditBtn.addEventListener('click', function() {
        editProfileModal.close();
    });

    // Cerrar modal haciendo clic fuera del contenido
    editProfileModal.addEventListener('click', function(event) {
        const rect = editProfileModal.getBoundingClientRect();
        const isInDialog = (
            rect.top <= event.clientY &&
            event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX &&
            event.clientX <= rect.left + rect.width
        );

        if (!isInDialog) {
            editProfileModal.close();
        }
    });

    // Función para cambiar pestañas
    function changeTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        document.querySelectorAll('.nav-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        document.getElementById(tabName + '-tab').classList.add('active');
        event.target.classList.add('active');
    }
</script>

<!-- Incluir FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection