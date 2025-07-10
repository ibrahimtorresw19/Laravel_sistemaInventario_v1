@extends('principal')

@section('content')
<style>
    /* Sistema de diseño moderno con variables CSS */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --success-color: #10b981;
        --success-hover: #0d9f6e;
        --danger-color: #ef4444;
        --danger-hover: #dc2626;
        --gray-color: #6c757d;
        --text-color: #334155;
        --light-bg: #f8fafc;
        --border-color: #e2e8f0;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        --space-xs: 0.5rem;
        --space-sm: 1rem;
        --space-md: 1.5rem;
        --space-lg: 2rem;
        --space-xl: 3rem;
    }

    /* Estilos base */
    .proveedores-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
    }

    /* Header y controles */
    .proveedores-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-lg);
        flex-wrap: wrap;
        gap: var(--space-sm);
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 0;
    }

    .controls-group {
        display: flex;
        gap: var(--space-sm);
        flex-wrap: wrap;
    }

    /* Botones */
    .btn {
        padding: var(--space-xs) var(--space-sm);
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        box-shadow: var(--shadow-sm);
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
    }

    .btn-success {
        background-color: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background-color: var(--success-hover);
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: var(--danger-hover);
    }

    .btn-gray {
        background-color: var(--gray-color);
        color: white;
    }

    .btn-icon {
        margin-right: var(--space-xs);
    }

    /* Tabla */
    .table-container {
        overflow-x: auto;
        margin-top: var(--space-lg);
        background-color: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table th {
        background-color: var(--light-bg);
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.8125rem;
        letter-spacing: 0.5px;
        padding: var(--space-sm) var(--space-md);
        text-align: left;
        position: sticky;
        top: 0;
    }

    .data-table td {
        padding: var(--space-sm) var(--space-md);
        border-bottom: 1px solid var(--light-bg);
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover {
        background-color: rgba(248, 250, 252, 0.7);
    }

    /* Badges */
    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        min-width: 70px;
        text-align: center;
        text-transform: uppercase;
    }

    .badge-active {
        background-color: var(--success-color);
        color: white;
    }

    .badge-inactive {
        background-color: var(--gray-color);
        color: white;
    }

    /* Acciones */
    .actions-cell {
        display: flex;
        gap: var(--space-xs);
        flex-wrap: wrap;
    }

    /* Formularios y Modales */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal {
        background-color: white;
        border-radius: var(--radius-lg);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(-20px);
        transition: var(--transition);
        position: relative;
    }

    .modal-overlay.active .modal {
        transform: translateY(0);
    }

    .modal-content {
        padding: var(--space-lg);
    }

    .modal-title {
        margin-top: 0;
        margin-bottom: var(--space-md);
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-md);
        margin-bottom: var(--space-md);
    }

    .form-group {
        margin-bottom: var(--space-sm);
    }

    .form-label {
        display: block;
        margin-bottom: var(--space-xs);
        font-weight: 600;
        color: #475569;
        font-size: 0.875rem;
    }

    .form-control {
        width: 100%;
        padding: var(--space-xs) var(--space-sm);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        transition: var(--transition);
        background-color: white;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: var(--space-sm);
        margin-top: var(--space-md);
    }

    /* Toggle switch */
    .toggle-container {
        margin-top: var(--space-xs);
    }

    .toggle-switch {
        position: relative;
        display: inline-flex;
        width: 100%;
        height: 2.625rem;
        background-color: #f1f5f9;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    }

    .toggle-option {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .toggle-slider {
        position: absolute;
        top: 0.1875rem;
        left: 0.1875rem;
        width: calc(50% - 0.375rem);
        height: calc(100% - 0.375rem);
        background-color: var(--primary-color);
        border-radius: calc(var(--radius-lg) - 0.1875rem);
        z-index: 1;
        transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55), background-color 0.3s;
    }

    .toggle-switch input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .toggle-switch input[type="radio"]:checked + label + input[type="radio"] + label ~ .toggle-slider {
        transform: translateX(100%);
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: var(--space-xl);
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: var(--space-sm);
        color: #cbd5e1;
    }

    /* Notificaciones */
    .notification {
        position: fixed;
        top: var(--space-md);
        right: var(--space-md);
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-md);
        color: white;
        z-index: 10000;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
        font-weight: 500;
        max-width: 90%;
    }

    .notification-success {
        background-color: var(--success-color);
    }

    .notification-error {
        background-color: var(--danger-color);
    }

    .notification-fade-out {
        opacity: 0;
        transform: translateY(-1.25rem);
    }

    /* Validación */
    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.8125rem;
        margin-top: 0.3125rem;
        font-weight: 500;
    }

    .is-invalid {
        border-color: var(--danger-color);
    }

    /* Paginación */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .pagination .pagination-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: var(--space-xs);
    }

    .pagination .page-item {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 var(--space-sm);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        background-color: white;
    }

    .pagination .page-link:hover {
        background-color: var(--light-bg);
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        color: #94a3b8;
        background-color: #f8fafc;
        border-color: var(--border-color);
        cursor: not-allowed;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0 var(--space-md);
    }

    .pagination .page-item .page-link svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    @media (max-width: 640px) {
        .pagination .page-link {
            min-width: 2rem;
            height: 2rem;
            padding: 0 var(--space-xs);
            font-size: 0.875rem;
        }
        
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0 var(--space-sm);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .proveedores-container {
            padding: var(--space-md);
        }
        
        .proveedores-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-sm);
        }
        
        .modal {
            width: 95%;
            padding: var(--space-md);
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .data-table {
            min-width: 100%;
        }
        
        .data-table td, .data-table th {
            padding: var(--space-xs) var(--space-sm);
        }
        
        .actions-cell {
            flex-direction: column;
        }
    }
</style>

<div class="proveedores-container">
    @if(session('success'))
        <div class="notification notification-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any()))
        <div class="notification notification-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="proveedores-header">
        <h1 class="page-title">Gestión de Proveedores</h1>
        <div class="controls-group">
            <a href="{{ route('Proveedores.pdf') }}" class="btn btn-gray" target="_blank">
                <i class="fas fa-file-pdf btn-icon"></i>Exportar PDF
            </a>
            <button id="openModal" class="btn btn-primary">
                <i class="fas fa-plus btn-icon"></i>Nuevo Proveedor
            </button>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proveedores as $proveedor)
                <tr data-id="{{ $proveedor->id }}">
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->email }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>
                        <span class="badge {{ $proveedor->activo ? 'badge-active' : 'badge-inactive' }}">
                            {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="actions-cell">
                        <button class="btn btn-primary edit-btn" 
                            data-id="{{ $proveedor->id }}"
                            data-nombre="{{ $proveedor->nombre }}"
                            data-telefono="{{ $proveedor->telefono }}"
                            data-email="{{ $proveedor->email }}"
                            data-direccion="{{ $proveedor->direccion }}"
                            data-activo="{{ $proveedor->activo }}">
                            <i class="fas fa-edit btn-icon"></i>Editar
                        </button>
                        <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display: inline;">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                <i class="fas fa-trash-alt btn-icon"></i>Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: var(--space-lg); color: #64748b;">
                        No hay proveedores registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="pagination">
        {{ $proveedores->links() }}
    </div>
</div>

<!-- Modal para crear nuevo proveedor -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Crear Nuevo Proveedor</h2>
            <form action="{{ route('proveedores.store') }}" method="POST" id="create-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre*</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" required value="{{ old('nombre') }}" placeholder="Nombre del proveedor">
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono*</label>
                        <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" required value="{{ old('telefono') }}" placeholder="Teléfono del proveedor">
                        @error('telefono')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}" placeholder="Email del proveedor">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección*</label>
                        <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" required value="{{ old('direccion') }}" placeholder="Dirección del proveedor">
                        @error('direccion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado*</label>
                        <div class="toggle-container">
                            <div class="toggle-switch">
                                <input type="radio" name="activo" id="estado-activo" value="1" {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                <input type="radio" name="activo" id="estado-inactivo" value="0" {{ old('activo') == '0' ? 'checked' : '' }}>
                                <label for="estado-activo" class="toggle-option">Activo</label>
                                <label for="estado-inactivo" class="toggle-option">Inactivo</label>
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        @error('activo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save btn-icon"></i>Guardar
                    </button>
                    <button type="button" id="closeModal" class="btn btn-danger">
                        <i class="fas fa-times btn-icon"></i>Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar proveedor -->
<div class="modal-overlay" id="modalEditOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Editar Proveedor</h2>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="activo" id="edit-activo-hidden" value="1">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit-nombre" class="form-label">Nombre*</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                        <span class="invalid-feedback" id="edit-nombre-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-telefono" class="form-label">Teléfono*</label>
                        <input type="text" name="telefono" id="edit-telefono" class="form-control" required>
                        <span class="invalid-feedback" id="edit-telefono-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-email" class="form-label">Email*</label>
                        <input type="email" name="email" id="edit-email" class="form-control" required>
                        <span class="invalid-feedback" id="edit-email-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-direccion" class="form-label">Dirección*</label>
                        <input type="text" name="direccion" id="edit-direccion" class="form-control" required>
                        <span class="invalid-feedback" id="edit-direccion-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado*</label>
                        <div class="toggle-container">
                            <div class="toggle-switch">
                                <input type="radio" name="activo_radio" id="edit-estado-activo" value="1" checked>
                                <input type="radio" name="activo_radio" id="edit-estado-inactivo" value="0">
                                <label for="edit-estado-activo" class="toggle-option">Activo</label>
                                <label for="edit-estado-inactivo" class="toggle-option">Inactivo</label>
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        <span class="invalid-feedback" id="edit-activo-error"></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save btn-icon"></i>Actualizar
                    </button>
                    <button type="button" class="btn btn-danger close-edit-modal">
                        <i class="fas fa-times btn-icon"></i>Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalOverlay = document.getElementById('modalOverlay');
        const modalEditOverlay = document.getElementById('modalEditOverlay');
        const openButton = document.getElementById('openModal');
        const closeButton = document.getElementById('closeModal');
        const closeEditButtons = document.querySelectorAll('.close-edit-modal');
        const editForm = document.getElementById('edit-form');
        const notification = document.querySelector('.notification');

        // Configuración inicial del toggle switch
        function setupToggleSwitch(container) {
            const slider = container.querySelector('.toggle-slider');
            const checkedInput = container.querySelector('input[type="radio"]:checked');
            
            if (checkedInput && checkedInput.value === '0') {
                slider.style.transform = 'translateX(100%)';
                slider.style.backgroundColor = 'var(--danger-color)';
            }
            
            container.querySelectorAll('input[type="radio"]').forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === '1') {
                        slider.style.transform = 'translateX(0)';
                        slider.style.backgroundColor = 'var(--primary-color)';
                    } else {
                        slider.style.transform = 'translateX(100%)';
                        slider.style.backgroundColor = 'var(--danger-color)';
                    }
                });
            });
        }

        // Inicializar toggles
        setupToggleSwitch(document.querySelector('#modalOverlay .toggle-switch'));
        setupToggleSwitch(document.querySelector('#modalEditOverlay .toggle-switch'));

        // Abrir modal de creación
        openButton.addEventListener('click', () => {
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Cerrar modal de creación
        closeButton.addEventListener('click', () => {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Cerrar modal de edición
        closeEditButtons.forEach(button => {
            button.addEventListener('click', () => {
                modalEditOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Cerrar modales al hacer clic fuera
        [modalOverlay, modalEditOverlay].forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Manejar edición de proveedores
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const telefono = this.getAttribute('data-telefono');
                const email = this.getAttribute('data-email');
                const direccion = this.getAttribute('data-direccion');
                const activo = this.getAttribute('data-activo');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nombre').value = nombre;
                document.getElementById('edit-telefono').value = telefono;
                document.getElementById('edit-email').value = email;
                document.getElementById('edit-direccion').value = direccion;
                document.getElementById('edit-activo-hidden').value = activo;

                if(activo === '1') {
                    document.getElementById('edit-estado-activo').checked = true;
                    document.querySelector('#modalEditOverlay .toggle-slider').style.transform = 'translateX(0)';
                    document.querySelector('#modalEditOverlay .toggle-slider').style.backgroundColor = 'var(--primary-color)';
                } else {
                    document.getElementById('edit-estado-inactivo').checked = true;
                    document.querySelector('#modalEditOverlay .toggle-slider').style.transform = 'translateX(100%)';
                    document.querySelector('#modalEditOverlay .toggle-slider').style.backgroundColor = 'var(--danger-color)';
                }

                editForm.action = `/proveedores/${id}`;
                modalEditOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Actualizar el campo oculto cuando cambia el toggle
        document.querySelectorAll('#modalEditOverlay input[name="activo_radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('edit-activo-hidden').value = this.value;
            });
        });

        // Manejar el envío del formulario de edición
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Asegurarse de que el valor del estado esté actualizado
            const selectedRadio = document.querySelector('#modalEditOverlay input[name="activo_radio"]:checked');
            if (selectedRadio) {
                document.getElementById('edit-activo-hidden').value = selectedRadio.value;
            }
            
            const formData = new FormData(editForm);
            const url = editForm.action;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                if (error.errors) {
                    // Limpiar errores anteriores
                    document.querySelectorAll('#edit-form .invalid-feedback').forEach(el => {
                        el.textContent = '';
                    });
                    
                    // Mostrar nuevos errores
                    for (const [field, messages] of Object.entries(error.errors)) {
                        const errorElement = document.getElementById(`edit-${field}-error`);
                        if (errorElement) {
                            errorElement.textContent = messages[0];
                        }
                    }
                } else {
                    console.error('Error:', error);
                    alert('Error al actualizar el proveedor');
                }
            });
        });

        // Auto cerrar notificación
        if (notification) {
            setTimeout(() => {
                notification.classList.add('notification-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Recargar la página cuando se navega desde el cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    });
</script>
@endsection
