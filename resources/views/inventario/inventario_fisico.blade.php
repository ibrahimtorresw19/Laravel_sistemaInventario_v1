@extends('principal')

@section('content')
<style>
    /* Variables CSS */
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

    /* Estilos generales */
    .inventario-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
    }

    /* Header */
    .inventario-header {
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
        text-transform: capitalize;
    }

    .badge-planificado {
        background-color: #93c5fd;
        color: #1e40af;
    }

    .badge-en_progreso {
        background-color: #86efac;
        color: #166534;
    }

    .badge-completado {
        background-color: #a5b4fc;
        color: #3730a3;
    }

    .badge-cancelado {
        background-color: #fca5a5;
        color: #991b1b;
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

    /* Acciones */
    .actions-cell {
        display: flex;
        gap: var(--space-xs);
        flex-wrap: wrap;
    }

    /* Modales */
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
        max-width: 900px;
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

    /* Formularios */
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

    /* Estado */
    .status-container {
        grid-column: span 2;
        margin-bottom: var(--space-sm);
    }

    .status-options {
        display: flex;
        gap: var(--space-xs);
        margin-top: var(--space-xs);
    }

    .status-option {
        flex: 1;
        position: relative;
    }

    .status-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-label {
        display: block;
        padding: var(--space-xs) var(--space-sm);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        font-weight: 500;
        font-size: 0.875rem;
        background-color: white;
    }

    .status-option input[type="radio"]:checked + .status-label {
        border-color: var(--primary-color);
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        font-weight: 600;
    }

    .status-option:nth-child(1) input[type="radio"]:checked + .status-label {
        border-color: #93c5fd;
        background-color: rgba(147, 197, 253, 0.1);
        color: #1e40af;
    }

    .status-option:nth-child(2) input[type="radio"]:checked + .status-label {
        border-color: #86efac;
        background-color: rgba(134, 239, 172, 0.1);
        color: #166534;
    }

    .status-option:nth-child(3) input[type="radio"]:checked + .status-label {
        border-color: #a5b4fc;
        background-color: rgba(165, 180, 252, 0.1);
        color: #3730a3;
    }

    .status-option:nth-child(4) input[type="radio"]:checked + .status-label {
        border-color: #fca5a5;
        background-color: rgba(252, 165, 165, 0.1);
        color: #991b1b;
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

    /* Responsive */
    @media (max-width: 768px) {
        .inventario-container {
            padding: var(--space-md);
        }
        
        .inventario-header {
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
        
        .status-container {
            grid-column: span 1;
        }
        
        .status-options {
            flex-direction: column;
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
        
        .pagination .page-link {
            min-width: 2rem;
            height: 2rem;
            padding: 0 var(--space-xs);
            font-size: 0.875rem;
        }
    }
</style>

<div class="inventario-container">
    <!-- Notificaciones -->
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

    <!-- Encabezado -->
    <div class="inventario-header">
        <h1 class="page-title">Gestión de Inventarios Físicos</h1>
        <div class="controls-group">
            <a href="{{ route('inventario_fisico.pdf') }}" class="btn btn-gray" target="_blank">
                <i class="fas fa-file-pdf btn-icon"></i>Exportar PDF
            </a>
            <button id="openModal" class="btn btn-primary">
                <i class="fas fa-plus btn-icon"></i>Crear Inventario
            </button>
        </div>
    </div>

    <!-- Tabla de inventarios -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Observaciones</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Persona Encargada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas as $data)
                <tr data-id="{{ $data->id }}">
                    <td>{{ $data->nombre }}</td>
                    <td>{{ $data->observaciones }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->fecha_inicio)->format('d/m/Y') }}</td>
                    <td>{{ $data->fecha_fin ? \Carbon\Carbon::parse($data->fecha_fin)->format('d/m/Y') : '' }}</td>
                    <td>
                        <span class="badge badge-{{ str_replace(' ', '_', strtolower($data->estado)) }}">
                            {{ $data->estado }}
                        </span>
                    </td>
                    <td>{{ $data->encargado }}</td>
                    <td class="actions-cell">
                        <button class="btn btn-primary edit-btn" 
                            data-id="{{ $data->id }}"
                            data-nombre="{{ $data->nombre }}"
                            data-observaciones="{{ $data->observaciones }}"
                            data-fecha_inicio="{{ $data->fecha_inicio }}"
                            data-fecha_fin="{{ $data->fecha_fin }}"
                            data-encargado="{{ $data->encargado }}"
                            data-estado="{{ $data->estado }}">
                            <i class="fas fa-edit btn-icon"></i>Editar
                        </button>
                        <form action="{{ route('inventarioFisico.destroy', $data->id) }}" method="POST" style="display: inline;">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt btn-icon"></i>Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: var(--space-lg); color: #64748b;">
                        No hay inventarios físicos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="pagination">
        {{ $datas->links() }}
    </div>
</div>

<!-- Modal para crear nuevo inventario -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Crear Nuevo Inventario Físico</h2>
            <form action="{{ route('inventarioFisico.store') }}" method="POST" id="create-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre*</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" required value="{{ old('nombre') }}" placeholder="Nombre del inventario">
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones*</label>
                        <input type="text" name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" required value="{{ old('observaciones') }}" placeholder="Ingrese observaciones">
                        @error('observaciones')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio*</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" required value="{{ old('fecha_inicio') }}">
                        @error('fecha_inicio')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control @error('fecha_fin') is-invalid @enderror" value="{{ old('fecha_fin') }}">
                        @error('fecha_fin')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="encargado" class="form-label">Persona Encargada*</label>
                        <input type="text" name="encargado" id="encargado" class="form-control @error('encargado') is-invalid @enderror" required value="{{ old('encargado') }}" placeholder="Nombre del encargado">
                        @error('encargado')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="status-container">
                        <label class="form-label">Estado*</label>
                        <div class="status-options">
                            <div class="status-option">
                                <input type="radio" name="estado" id="estado-planificado" value="planificado" {{ old('estado', 'planificado') == 'planificado' ? 'checked' : '' }}>
                                <label for="estado-planificado" class="status-label">Planificado</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="estado-en_progreso" value="en_progreso" {{ old('estado') == 'en_progreso' ? 'checked' : '' }}>
                                <label for="estado-en_progreso" class="status-label">En Progreso</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="estado-completado" value="completado" {{ old('estado') == 'completado' ? 'checked' : '' }}>
                                <label for="estado-completado" class="status-label">Completado</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="estado-cancelado" value="cancelado" {{ old('estado') == 'cancelado' ? 'checked' : '' }}>
                                <label for="estado-cancelado" class="status-label">Cancelado</label>
                            </div>
                        </div>
                        @error('estado')
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

<!-- Modal para editar inventario -->
<div class="modal-overlay" id="modalEditOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Editar Inventario Físico</h2>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit-nombre" class="form-label">Nombre*</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                        <span class="invalid-feedback" id="edit-nombre-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-observaciones" class="form-label">Observaciones*</label>
                        <input type="text" name="observaciones" id="edit-observaciones" class="form-control" required>
                        <span class="invalid-feedback" id="edit-observaciones-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-fecha_inicio" class="form-label">Fecha de inicio*</label>
                        <input type="date" name="fecha_inicio" id="edit-fecha_inicio" class="form-control" required>
                        <span class="invalid-feedback" id="edit-fecha_inicio-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-fecha_fin" class="form-label">Fecha fin</label>
                        <input type="date" name="fecha_fin" id="edit-fecha_fin" class="form-control">
                        <span class="invalid-feedback" id="edit-fecha_fin-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="edit-encargado" class="form-label">Persona Encargada*</label>
                        <input type="text" name="encargado" id="edit-encargado" class="form-control" required>
                        <span class="invalid-feedback" id="edit-encargado-error"></span>
                    </div>

                    <div class="status-container">
                        <label class="form-label">Estado*</label>
                        <div class="status-options">
                            <div class="status-option">
                                <input type="radio" name="estado" id="edit-estado-planificado" value="planificado">
                                <label for="edit-estado-planificado" class="status-label">Planificado</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="edit-estado-en_progreso" value="en_progreso">
                                <label for="edit-estado-en_progreso" class="status-label">En Progreso</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="edit-estado-completado" value="completado">
                                <label for="edit-estado-completado" class="status-label">Completado</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="estado" id="edit-estado-cancelado" value="cancelado">
                                <label for="edit-estado-cancelado" class="status-label">Cancelado</label>
                            </div>
                        </div>
                        <span class="invalid-feedback" id="edit-estado-error"></span>
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
        // Elementos del DOM
        const modalOverlay = document.getElementById('modalOverlay');
        const modalEditOverlay = document.getElementById('modalEditOverlay');
        const openButton = document.getElementById('openModal');
        const closeButton = document.getElementById('closeModal');
        const closeEditButtons = document.querySelectorAll('.close-edit-modal');
        const editForm = document.getElementById('edit-form');
        const notification = document.querySelector('.notification');

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

        // Manejar edición de inventarios
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const observaciones = this.getAttribute('data-observaciones');
                const fecha_inicio = this.getAttribute('data-fecha_inicio');
                const fecha_fin = this.getAttribute('data-fecha_fin');
                const encargado = this.getAttribute('data-encargado');
                const estado = this.getAttribute('data-estado');

                // Llenar formulario con datos
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nombre').value = nombre;
                document.getElementById('edit-observaciones').value = observaciones;
                document.getElementById('edit-fecha_inicio').value = fecha_inicio;
                document.getElementById('edit-fecha_fin').value = fecha_fin || '';
                document.getElementById('edit-encargado').value = encargado;

                // Configurar el estado
                const estadoInput = document.querySelector(`#modalEditOverlay input[value="${estado.toLowerCase()}"]`);
                if (estadoInput) {
                    estadoInput.checked = true;
                }

                // Configurar acción del formulario
                editForm.action = `{{ url('/inventarioFisico') }}/${id}`;
                modalEditOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Auto cerrar notificación
        if (notification) {
            setTimeout(() => {
                notification.classList.add('notification-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Manejar envío del formulario de edición
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Mostrar loader
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            submitBtn.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(this)
                });

                const data = await response.json();
                
                if (response.ok) {
                    window.location.reload();
                } else {
                    // Limpiar errores anteriores
                    document.querySelectorAll('#edit-form .invalid-feedback').forEach(el => el.textContent = '');
                    
                    // Mostrar errores de validación
                    if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const errorElement = document.getElementById(`edit-${field}-error`);
                            if (errorElement) errorElement.textContent = messages[0];
                        }
                    } else {
                        showNotification('Error: ' + (data.message || 'Error desconocido'), 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error de conexión al actualizar el inventario', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Función para mostrar notificaciones
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('notification-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    });
</script>
@endsection
