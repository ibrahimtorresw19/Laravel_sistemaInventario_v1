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
    .categorias-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
    }

    /* Header y controles */
    .categorias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-lg);
        flex-wrap: wrap;
        gap: var(--space-sm);
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

    /* User indicator */
    .user-badge {
        background-color: var(--primary-color);
        color: white;
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        margin-bottom: var(--space-md);
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
        min-width: 600px;
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
    }

    .badge-active {
        background-color: var(--success-color);
        color: white;
    }

    .badge-inactive {
        background-color: var(--danger-color);
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
        max-width: 800px;
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

    .empty-state-title {
        margin-bottom: var(--space-xs);
        color: #475569;
        font-size: 1.25rem;
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
    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-1.25rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .categorias-container {
            padding: var(--space-md);
        }
        
        .categorias-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .modal {
            width: 95%;
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
        
        .empty-state {
            padding: var(--space-lg);
        }
    }
</style>

@if(session('success'))
    <div class="notification notification-success">
        {{ session('success') }}
    </div>
@endif

<div class="categorias-container">
    <div class="categorias-header">
        <h1>Gestor de Categorías</h1>
        <div class="controls-group">
            <button id="openModal" class="btn btn-primary">
                <i class="fas fa-plus btn-icon"></i>Nueva categoría
            </button>
            <a href="{{ route('categorias.pdf') }}" class="btn btn-gray" target="_blank">
                <i class="fas fa-file-pdf btn-icon"></i>Exportar PDF
            </a>
        </div>
    </div>

    @if($categorias->count() > 0)
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <tr data-id="{{ $categoria->id }}" data-user-id="{{ $categoria->user_id }}">
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <span class="badge {{ $categoria->activo ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $categoria->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="actions-cell">
                                <button class="btn btn-primary btn-edit" data-id="{{ $categoria->id }}">
                                    <i class="fas fa-edit btn-icon"></i>Editar
                                </button>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display: inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
                                        <i class="fas fa-trash-alt btn-icon"></i>Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h3 class="empty-state-title">No hay categorías registradas</h3>
            <p>Comienza creando tu primera categoría</p>
        </div>
    @endif

    <!-- Paginación -->
    <div class="pagination">
        {{ $categorias->links() }}
    </div>
</div>

<!-- Modal Crear -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Crear Nueva Categoría</h2>
            <form action="{{ route('categorias.store') }}" method="POST" id="create-form">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                               required placeholder="Ej: Electrónica">
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" 
                               class="form-control @error('descripcion') is-invalid @enderror" 
                               required placeholder="Ej: Productos electrónicos">
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="toggle-container">
                            <div class="toggle-switch">
                                <input type="radio" name="estado" id="activo" value="1" checked>
                                <label for="activo" class="toggle-option">Activo</label>
                                
                                <input type="radio" name="estado" id="inactivo" value="0">
                                <label for="inactivo" class="toggle-option">Inactivo</label>
                                
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        @error('estado')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" id="closeModal" class="btn btn-danger">
                        <i class="fas fa-times btn-icon"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save btn-icon"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal-overlay" id="modalEditOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Editar Categoría</h2>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="user_id" id="edit-user-id" value="{{ auth()->id() }}">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit-nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                        <span class="invalid-feedback" id="edit-nombre-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="edit-descripcion" class="form-control" required>
                        <span class="invalid-feedback" id="edit-descripcion-error"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="toggle-container">
                            <div class="toggle-switch">
                                <input type="radio" name="estado" id="edit-activo" value="1">
                                <label for="edit-activo" class="toggle-option">Activo</label>
                                
                                <input type="radio" name="estado" id="edit-inactivo" value="0">
                                <label for="edit-inactivo" class="toggle-option">Inactivo</label>
                                
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        <span class="invalid-feedback" id="edit-estado-error"></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-danger close-edit-modal">
                        <i class="fas fa-times btn-icon"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save btn-icon"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
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

        // Manejar edición de categorías
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const id = row.getAttribute('data-id');
                const userId = row.getAttribute('data-user-id');
                const currentUserId = "{{ auth()->id() }}";
                
                // Verificar permisos
                if(userId !== currentUserId) {
                    alert('No tienes permiso para editar esta categoría');
                    return;
                }

                // Obtener datos de la fila
                const nombre = row.cells[0].textContent;
                const descripcion = row.cells[1].textContent;
                const estado = row.querySelector('.badge').classList.contains('badge-active') ? '1' : '0';

                // Rellenar formulario
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nombre').value = nombre;
                document.getElementById('edit-descripcion').value = descripcion;
                document.getElementById('edit-user-id').value = currentUserId;

                // Establecer estado
                if(estado === '1') {
                    document.getElementById('edit-activo').checked = true;
                    document.querySelector('#modalEditOverlay .toggle-slider').style.transform = 'translateX(0)';
                    document.querySelector('#modalEditOverlay .toggle-slider').style.backgroundColor = 'var(--primary-color)';
                } else {
                    document.getElementById('edit-inactivo').checked = true;
                    document.querySelector('#modalEditOverlay .toggle-slider').style.transform = 'translateX(100%)';
                    document.querySelector('#modalEditOverlay .toggle-slider').style.backgroundColor = 'var(--danger-color)';
                }

                // Establecer acción del formulario
                editForm.action = `/categorias/${id}`;
                modalEditOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Verificar permisos para eliminar
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function(e) {
                const row = this.closest('tr');
                const userId = row.getAttribute('data-user-id');
                const currentUserId = "{{ auth()->id() }}";
                
                if(userId !== currentUserId) {
                    e.preventDefault();
                    alert('No tienes permiso para eliminar esta categoría');
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
