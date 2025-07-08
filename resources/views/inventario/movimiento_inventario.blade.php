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
    .movimientos-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
    }

    /* Header y controles */
    .movimientos-header {
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

    .btn-secondary {
        background-color: var(--gray-color);
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
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

    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .badge-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
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

    .modal-header {
        padding: var(--space-md);
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border-top-left-radius: var(--radius-lg);
        border-top-right-radius: var(--radius-lg);
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
    }

    .modal-content {
        padding: var(--space-lg);
    }

    .modal-footer {
        padding: var(--space-md);
        background-color: var(--light-bg);
        display: flex;
        justify-content: flex-end;
        gap: var(--space-sm);
        border-bottom-left-radius: var(--radius-lg);
        border-bottom-right-radius: var(--radius-lg);
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

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-control:disabled {
        background-color: #f1f5f9;
        cursor: not-allowed;
    }

    /* Stock feedback */
    .stock-info {
        font-size: 0.75rem;
        margin-top: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-md);
        background-color: var(--light-bg);
        display: inline-block;
    }
    
    .stock-warning {
        color: var(--warning-color);
        font-weight: 600;
    }
    
    .stock-danger {
        color: var(--danger-color);
        font-weight: 600;
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

    /* Responsive */
    @media (max-width: 768px) {
        .movimientos-container {
            padding: var(--space-md);
        }
        
        .movimientos-header {
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
        
        .actions-cell {
            flex-direction: column;
        }
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

    @media (max-width: 480px) {
        .data-table {
            min-width: 100%;
        }
        
        .data-table td, .data-table th {
            padding: var(--space-xs) var(--space-sm);
        }
    }
</style>

<div class="movimientos-container">
    @if(session('success'))
        <div class="notification notification-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="notification notification-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="movimientos-header">
        <h1 class="page-title">Movimientos de Inventario</h1>
        <div class="controls-group">
            <a href="{{ route('Movimientos.pdf') }}" class="btn btn-gray" target="_blank">
                <i class="fas fa-file-pdf btn-icon"></i>Exportar PDF
            </a>
            <button id="openModal" class="btn btn-primary">
                <i class="fas fa-plus btn-icon"></i>Nuevo Movimiento
            </button>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Almacén</th>
                    <th>Registrado por</th>
                    <th>Responsable</th>
                    <th>Fecha Movimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $movimiento)
                <tr data-id="{{ $movimiento->id }}">
                    <td>
                        @if($movimiento->tipo == 'entrada')
                            <span class="badge badge-success">Entrada</span>
                        @elseif($movimiento->tipo == 'salida')
                            <span class="badge badge-danger">Salida</span>
                        @else
                            <span class="badge badge-info">Ajuste</span>
                        @endif
                    </td>
                    <td>{{ number_format($movimiento->cantidad) }}</td>
                    <td>{{ $movimiento->producto->nombre ?? 'N/A' }}</td>
                    <td>{{ $movimiento->almacen->nombre ?? 'N/A' }}</td>
                    <td>{{ $movimiento->user->name }}</td>
                    <td>{{ $movimiento->responsable ?? 'N/A' }}</td>
                    <td>{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</td>
                    <td class="actions-cell">
                        <button class="btn btn-secondary btn-view" data-id="{{ $movimiento->id }}">
                            <i class="fas fa-eye btn-icon"></i>Ver
                        </button>
                     
                    <form action="{{ route('movimientos.destroy', $movimiento->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" 
            onclick="return confirm('¿Estás seguro de eliminar este movimiento?')">
        <i class="fas fa-trash-alt"></i> Eliminar
    </button>
</form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: var(--space-lg); color: #64748b;">
                        No hay movimientos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="pagination">
        {{ $movimientos->links() }}
    </div>
</div>

<!-- Modal para crear/editar movimiento -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Registrar Nuevo Movimiento</h2>
        </div>
        <form id="movimientoForm" action="{{ route('movimientos.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" id="movimientoId" name="id">
            <input type="hidden" id="currentStock" value="0">

            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo" class="form-label">Tipo de Movimiento*</label>
                    <select class="form-control @error('tipo') is-invalid @enderror" name="tipo" id="tipo" required>
                        <option value="">Seleccione...</option>
                        <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                        <option value="ajuste" {{ old('tipo') == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                    </select>
                    @error('tipo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cantidad" class="form-label">Cantidad*</label>
                    <input type="number" class="form-control @error('cantidad') is-invalid @enderror" 
                           name="cantidad" id="cantidad" min="1" value="{{ old('cantidad') }}" required>
                    <div id="stockFeedback" class="stock-info"></div>
                    @error('cantidad')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="producto_id" class="form-label">Producto*</label>
                    <select class="form-control @error('producto_id') is-invalid @enderror" name="producto_id" id="producto_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-stock="{{ $producto->stock_actual }}"
                            {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }} (Stock: {{ $producto->stock_actual }})
                        </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="almacen_id" class="form-label">Almacén</label>
                    <select class="form-control @error('almacen_id') is-invalid @enderror" name="almacen_id" id="almacen_id">
                        <option value="">Seleccione...</option>
                        @foreach($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('almacen_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="responsable" class="form-label">Responsable</label>
                    <input type="text" class="form-control @error('responsable') is-invalid @enderror" 
                           name="responsable" id="responsable" value="{{ old('responsable') }}">
                    @error('responsable')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_movimiento" class="form-label">Fecha de Movimiento*</label>
                    <input type="datetime-local" class="form-control @error('fecha_movimiento') is-invalid @enderror" 
                           name="fecha_movimiento" id="fecha_movimiento" value="{{ old('fecha_movimiento') }}" required>
                    @error('fecha_movimiento')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_registro" class="form-label">Fecha de Registro*</label>
                    <input type="datetime-local" class="form-control @error('fecha_registro') is-invalid @enderror" 
                           name="fecha_registro" id="fecha_registro" value="{{ old('fecha_registro') }}" required>
                    @error('fecha_registro')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="motivo" class="form-label">Motivo*</label>
                    <textarea class="form-control @error('motivo') is-invalid @enderror" 
                              name="motivo" id="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                    @error('motivo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalBtn">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para ver detalles -->
<div class="modal-overlay" id="viewModalOverlay">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Detalles del Movimiento</h2>
        </div>
        <div class="modal-content">
            <div class="form-grid">
                <div class="form-group">
                    <p><strong>Tipo:</strong> <span id="viewTipo"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Cantidad:</strong> <span id="viewCantidad"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Producto:</strong> <span id="viewProducto"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Almacén:</strong> <span id="viewAlmacen"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Registrado por:</strong> <span id="viewUsuario"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Responsable:</strong> <span id="viewResponsable"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Fecha Movimiento:</strong> <span id="viewFecha"></span></p>
                </div>
                <div class="form-group">
                    <p><strong>Fecha Registro:</strong> <span id="viewFechaRegistro"></span></p>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <p><strong>Motivo:</strong></p>
                    <p id="viewMotivo" class="p-2 bg-light rounded"></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeViewModalBtn">Cerrar</button>
        </div>
    </div>
</div>

<!-- Agregar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Agregar Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Agregar Select2 para mejores selects -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Auto cerrar notificaciones después de 3 segundos
        setTimeout(function() {
            $('.notification').fadeOut('slow');
        }, 3000);

        // Inicializar Select2
        $('#producto_id, #almacen_id').select2({
            placeholder: "Seleccione una opción",
            allowClear: true,
            dropdownParent: $('#modalOverlay')
        });

        // Configurar fechas actuales por defecto
        const now = new Date();
        const formattedDateTime = now.toISOString().slice(0, 16);
        $('#fecha_movimiento').val(formattedDateTime);
        $('#fecha_registro').val(formattedDateTime);

        // Abrir modal para nuevo movimiento
        $('#openModal').click(function() {
            $('#movimientoForm').trigger('reset');
            $('#movimientoId').val('');
            $('#modalTitle').text("Registrar Nuevo Movimiento");
            $('#stockFeedback').text('').removeClass('stock-warning stock-danger');
            
            // Restablecer fechas
            const now = new Date();
            const formattedDateTime = now.toISOString().slice(0, 16);
            $('#fecha_movimiento').val(formattedDateTime);
            $('#fecha_registro').val(formattedDateTime);
            
            $('#modalOverlay').addClass('active');
            $('body').css('overflow', 'hidden');
        });

        // Cerrar modal principal
        $('#closeModalBtn').click(function() {
            $('#modalOverlay').removeClass('active');
            $('body').css('overflow', '');
        });

        // Cerrar modal de visualización
        $('#closeViewModalBtn').click(function() {
            $('#viewModalOverlay').removeClass('active');
            $('body').css('overflow', '');
        });

        // Cerrar modales al hacer clic fuera
        $('.modal-overlay').click(function(e) {
            if (e.target === this) {
                $(this).removeClass('active');
                $('body').css('overflow', '');
            }
        });

        // Actualizar información de stock cuando cambia el producto
        $('#producto_id').change(function() {
            const selectedOption = $(this).find('option:selected');
            const stockActual = selectedOption.data('stock') || 0;
            $('#currentStock').val(stockActual);
            updateStockFeedback(stockActual, $('#tipo').val(), $('#cantidad').val());
        });

        // Validar stock cuando cambia el tipo o la cantidad en el modal principal
        $('#tipo, #cantidad').on('change input', function() {
            const stockActual = $('#currentStock').val();
            const tipo = $('#tipo').val();
            const cantidad = $('#cantidad').val();
            updateStockFeedback(stockActual, tipo, cantidad);
        });

        // Función para actualizar el feedback de stock en el modal principal
        function updateStockFeedback(stock, tipo, cantidad) {
            const feedback = $('#stockFeedback');
            
            if (!tipo || !stock) {
                feedback.text('').removeClass('stock-warning stock-danger');
                $('#submitBtn').prop('disabled', false);
                return;
            }

            if (tipo === 'salida') {
                if (cantidad > stock) {
                    feedback.text(`Stock insuficiente. Disponible: ${stock}`)
                           .addClass('stock-danger')
                           .removeClass('stock-warning');
                    $('#submitBtn').prop('disabled', true);
                } else if (cantidad > 0) {
                    feedback.text(`Stock disponible: ${stock}`)
                           .removeClass('stock-danger stock-warning');
                    $('#submitBtn').prop('disabled', false);
                } else {
                    feedback.text(`Stock disponible: ${stock}`)
                           .removeClass('stock-danger stock-warning');
                    $('#submitBtn').prop('disabled', false);
                }
            } else {
                feedback.text(tipo === 'entrada' ? 'Se agregará al inventario' : 'Ajuste de inventario')
                       .removeClass('stock-danger stock-warning');
                $('#submitBtn').prop('disabled', false);
            }
        }

        // Manejar clic en botón de ver
        $('.btn-view').click(function() {
            const movimientoId = $(this).data('id');

            $.ajax({
                url: `/movimientos/${movimientoId}`,
                type: 'GET',
                success: function(data) {
                    $('#viewTipo').text(data.tipo.charAt(0).toUpperCase() + data.tipo.slice(1));
                    $('#viewCantidad').text(data.cantidad);
                    $('#viewProducto').text(data.producto.nombre);
                    $('#viewAlmacen').text(data.almacen ? data.almacen.nombre : 'N/A');
                    $('#viewUsuario').text(data.user.name);
                    $('#viewResponsable').text(data.responsable || 'N/A');
                    $('#viewMotivo').text(data.motivo);

                    // Formatear fechas
                    const fechaMov = new Date(data.fecha_movimiento);
                    const fechaReg = new Date(data.fecha_registro);
                    
                    $('#viewFecha').text(fechaMov.toLocaleDateString() + ' ' + fechaMov.toLocaleTimeString());
                    $('#viewFechaRegistro').text(fechaReg.toLocaleDateString() + ' ' + fechaReg.toLocaleTimeString());

                    $('#viewModalOverlay').addClass('active');
                    $('body').css('overflow', 'hidden');
                },
                error: function() {
                    alert('No se pudieron cargar los datos del movimiento');
                }
            });
        });
    });
</script>
@endsection