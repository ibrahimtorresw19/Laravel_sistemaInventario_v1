@extends('principal')

@section('content')

@section('styles')
<style>
    /* Estilos generales */
    .profile-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        background-color: #4e73df;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #3a5bc7;
    }

    .btn-secondary {
        background-color: #64748b;
        color: white;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #475569;
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

    /* Estilos para múltiples empresas */
    .empresas-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #4e73df;
        margin: 1.5rem 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Estilos para el modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* Estilos para campos requeridos */
    .required-field::after {
        content: " *";
        color: #e74a3b;
    }

    /* Estilos para vista previa de imagen */
    .image-preview {
        max-width: 150px;
        max-height: 150px;
        margin-top: 10px;
        display: none;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        object-fit: cover;
    }

    /* Estilos para imagen actual */
    .current-logo {
        max-width: 150px;
        max-height: 150px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        object-fit: cover;
    }

    /* Estilos para recomendaciones */
    .recommendations {
        background-color: #f8fafc;
        border-radius: 6px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .recommendations ul {
        list-style-type: none;
        padding-left: 0;
    }

    .recommendations li {
        margin-bottom: 0.5rem;
        color: #6c757d;
    }

    /* Estilos para validación */
    .is-invalid {
        border-color: #e74a3b !important;
    }

    .invalid-feedback {
        color: #e74a3b;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Estilo para cuando no hay imagen */
    .no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        color: #9ca3af;
        width: 100%;
        height: 100%;
    }

    /* Estilos responsivos */
    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-body {
            padding: 1.5rem;
        }
        
        .modal-content {
            width: 95%;
        }
    }

    /* Debug info */
    .debug-info {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 9999;
    }
</style>
@endsection

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Empresa</h1>

    <!-- Debug info (solo para desarrollo) -->
    @if(env('APP_DEBUG'))
    <div class="debug-info">
        User ID: {{ Auth::id() }} | 
        Empresas: {{ $empresas->count() }}
    </div>
    @endif

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

    <div class="empresas-container">
        @foreach($empresas as $empresa)
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        @if($empresa->imagen)
                            <img src="{{ asset('storage/' . $empresa->imagen) }}" alt="Logo de {{ $empresa->nombre }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-building text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold">{{ $empresa->nombre }}</h2>
                    <p class="opacity-90">RUC: {{ $empresa->RUC }}</p>
                    <p class="text-xs opacity-75">ID: {{ $empresa->id }} | User ID: {{ $empresa->user_id }}</p>
                </div>

                <div class="profile-body">
                    <div class="nav-tabs">
                        <div class="nav-tab active" onclick="changeTab('profile-{{ $empresa->id }}')">Perfil</div>
                    </div>

                    <div id="profile-{{ $empresa->id }}-tab" class="tab-content active">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <h3 class="section-title md:col-span-2">
                                <i class="fas fa-info-circle me-2"></i>Información Básica
                            </h3>

                            <div class="form-group">
                                <label class="form-label">Nombre de la Empresa</label>
                                <p>{{ $empresa->nombre ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">RUC</label>
                                <p>{{ $empresa->RUC ?? 'No especificado' }}</p>
                            </div>

                            <h3 class="section-title md:col-span-2">
                                <i class="fas fa-address-book me-2"></i> Información de Contacto
                            </h3>

                            <div class="form-group">
                                <label class="form-label">Teléfono</label>
                                <p>{{ $empresa->telefono ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <p>{{ $empresa->email ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="form-label">Dirección</label>
                                <p>{{ $empresa->direccion ?? 'No especificado' }}</p>
                            </div>

                            <h3 class="section-title md:col-span-2">
                                <i class="fas fa-building-circle-check me-2"></i> Detalles Adicionales
                            </h3>

                            <div class="form-group">
                                <label class="form-label">Industria</label>
                                <p>{{ $empresa->Industria ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Representante Legal</label>
                                <p>{{ $empresa->representante_legal ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Fecha de Fundación</label>
                                <p>{{ $empresa->fecha_fundacion ? \Carbon\Carbon::parse($empresa->fecha_fundacion)->format('d/m/Y') : 'No especificado' }}</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Moneda Principal</label>
                                <p>{{ $empresa->moneda ?? 'No especificado' }}</p>
                            </div>

                            <div class="form-group md:col-span-2">
                                <label class="form-label">Descripción de la Empresa</label>
                                <p>{{ $empresa->descripcion_de_la_empresa ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button class="btn btn-primary" onclick="openEditModal({{ $empresa->id }})">
                                <i class="fas fa-edit me-2"></i>Editar Empresa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Edición para cada empresa -->
            <div id="editModal-{{ $empresa->id }}" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Editar Empresa</h3>
                        <button class="modal-close" onclick="closeEditModal({{ $empresa->id }})">&times;</button>
                    </div>
                    <form method="POST" action="{{ route('empresas.update', $empresa->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <div class="modal-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <h3 class="section-title md:col-span-2">
                                    <i class="fas fa-info-circle me-2"></i>Información Básica
                                </h3>

                                <div class="form-group">
                                    <label class="form-label required-field">Nombre de la Empresa</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                           name="nombre" value="{{ old('nombre', $empresa->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label required-field">RUC</label>
                                    <input type="text" class="form-control @error('RUC') is-invalid @enderror" 
                                           name="RUC" value="{{ old('RUC', $empresa->RUC) }}" required>
                                    @error('RUC')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h3 class="section-title md:col-span-2">
                                    <i class="fas fa-address-book me-2"></i> Información de Contacto
                                </h3>

                                <div class="form-group">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                           name="telefono" value="{{ old('telefono', $empresa->telefono) }}">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $empresa->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                                           name="direccion" value="{{ old('direccion', $empresa->direccion) }}">
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h3 class="section-title md:col-span-2">
                                    <i class="fas fa-building-circle-check me-2"></i> Detalles Adicionales
                                </h3>

                                <div class="form-group">
                                    <label class="form-label">Industria</label>
                                    <input type="text" class="form-control @error('Industria') is-invalid @enderror" 
                                           name="Industria" value="{{ old('Industria', $empresa->Industria) }}">
                                    @error('Industria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Representante Legal</label>
                                    <input type="text" class="form-control @error('representante_legal') is-invalid @enderror" 
                                           name="representante_legal" value="{{ old('representante_legal', $empresa->representante_legal) }}">
                                    @error('representante_legal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Fecha de Fundación</label>
                                    <input type="date" class="form-control @error('fecha_fundacion') is-invalid @enderror" 
                                           name="fecha_fundacion" value="{{ old('fecha_fundacion', $empresa->fecha_fundacion ? \Carbon\Carbon::parse($empresa->fecha_fundacion)->format('Y-m-d') : '') }}">
                                    @error('fecha_fundacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label required-field">Moneda Principal</label>
                                    <select class="form-control @error('moneda') is-invalid @enderror" name="moneda" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="USD" {{ old('moneda', $empresa->moneda) == 'USD' ? 'selected' : '' }}>USD - Dólar Estadounidense</option>
                                        <option value="EUR" {{ old('moneda', $empresa->moneda) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="MXN" {{ old('moneda', $empresa->moneda) == 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                        <option value="PEN" {{ old('moneda', $empresa->moneda) == 'PEN' ? 'selected' : '' }}>PEN - Sol Peruano</option>
                                        <option value="COP" {{ old('moneda', $empresa->moneda) == 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                                        <option value="CLP" {{ old('moneda', $empresa->moneda) == 'CLP' ? 'selected' : '' }}>CLP - Peso Chileno</option>
                                        <option value="ARS" {{ old('moneda', $empresa->moneda) == 'ARS' ? 'selected' : '' }}>ARS - Peso Argentino</option>
                                        <option value="BRL" {{ old('moneda', $empresa->moneda) == 'BRL' ? 'selected' : '' }}>BRL - Real Brasileño</option>
                                        <option value="other">Otra moneda</option>
                                    </select>
                                    @error('moneda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label class="form-label">Descripción de la Empresa</label>
                                    <textarea class="form-control @error('descripcion_de_la_empresa') is-invalid @enderror" 
                                              name="descripcion_de_la_empresa" rows="3">{{ old('descripcion_de_la_empresa', $empresa->descripcion_de_la_empresa) }}</textarea>
                                    @error('descripcion_de_la_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label class="form-label">Logo de la Empresa</label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                                           name="imagen" id="logo-{{ $empresa->id }}" 
                                           accept="image/*" onchange="previewImage(this, 'imagePreview-{{ $empresa->id }}')">
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-sm text-gray-600 mt-1">
                                        Formatos aceptados: JPG, PNG, SVG. Tamaño máximo: 2MB
                                    </div>

                                    <!-- Vista previa de la nueva imagen -->
                                    <img id="imagePreview-{{ $empresa->id }}" class="image-preview mt-2" 
                                         src="#" alt="Vista previa del logo" style="display: none;">
                                    
                                    <!-- Imagen actual -->
                                    @if($empresa->imagen)
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-600 mb-1">Logo actual:</p>
                                            <img src="{{ asset('storage/' . $empresa->imagen) }}" 
                                                 class="current-logo">
                                            <div class="mt-2 flex items-center">
                                                <input type="checkbox" name="eliminar_logo" id="eliminar_logo-{{ $empresa->id }}" 
                                                       class="mr-2">
                                                <label for="eliminar_logo-{{ $empresa->id }}" class="text-sm text-gray-700">
                                                    Eliminar logo actual
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Recomendaciones -->
                                    <div class="recommendations mt-3">
                                        <h6 class="text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-lightbulb mr-1"></i>Recomendaciones
                                        </h6>
                                        <ul class="text-xs text-gray-600">
                                            <li class="mb-1">• Usa una imagen cuadrada para mejor resultado</li>
                                            <li class="mb-1">• El fondo transparente es ideal</li>
                                            <li>• Resolución mínima recomendada: 200x200px</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeEditModal({{ $empresa->id }})">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    // Función para cambiar entre pestañas
    function changeTab(tabName) {
        const empresaId = tabName.split('-')[1];
        
        // Ocultar todas las pestañas de esta empresa
        document.querySelectorAll(`#profile-${empresaId}-tab`).forEach(tab => {
            tab.classList.remove('active');
        });

        // Desactivar todos los botones de pestaña de esta empresa
        document.querySelectorAll(`[onclick="changeTab('profile-${empresaId}')"]`).forEach(tab => {
            tab.classList.remove('active');
        });

        // Mostrar la pestaña seleccionada
        document.getElementById(tabName + '-tab').classList.add('active');

        // Activar el botón de pestaña seleccionado
        event.target.classList.add('active');
    }

    // Función para abrir el modal de edición
    function openEditModal(empresaId) {
        console.log('Abriendo modal para empresa:', empresaId);
        document.getElementById(`editModal-${empresaId}`).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Función para cerrar el modal de edición
    function closeEditModal(empresaId) {
        console.log('Cerrando modal para empresa:', empresaId);
        document.getElementById(`editModal-${empresaId}`).classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Cerrar el modal al hacer clic fuera del contenido
    window.onclick = function(event) {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target === modal) {
                console.log('Clic fuera del modal, cerrando...');
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Función para vista previa de imágenes
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            // Validar tamaño (2MB máximo)
            if (file.size > 2 * 1024 * 1024) {
                alert('El archivo es demasiado grande. El tamaño máximo permitido es 2MB.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '#';
        }
    }

    // Validación de formulario
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                console.log('Validando formulario...');
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    console.log('Formulario no válido');
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Validación del RUC (solo números, máximo 11 dígitos)
    document.addEventListener('DOMContentLoaded', function() {
        const rucInputs = document.querySelectorAll('input[name="RUC"]');
        rucInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let ruc = e.target.value.replace(/\D/g, '');
                if (ruc.length > 11) ruc = ruc.substring(0, 11);
                e.target.value = ruc;
            });
        });

        // Validación del teléfono (solo números)
        const telefonoInputs = document.querySelectorAll('input[name="telefono"]');
        telefonoInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        });

        // Debug: Mostrar info de las empresas
        console.log('Empresas cargadas:', @json($empresas));
    });
</script>
@endsection