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
    .productos-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--space-lg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
    }

    /* Header y controles */
    .productos-header {
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
        min-width: 1000px;
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

    /* Imágenes */
    .img-preview {
        max-width: 100px;
        max-height: 100px;
        margin-top: var(--space-xs);
        border-radius: var(--radius-md);
        border: 2px solid var(--border-color);
    }

    .table-img {
        max-width: 50px;
        max-height: 50px;
        border-radius: 4px;
        object-fit: cover;
        border: 1px solid var(--border-color);
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

    /* Responsive */
    @media (max-width: 768px) {
        .productos-container {
            padding: var(--space-md);
        }
        
        .productos-header {
            flex-direction: column;
            align-items: flex-start;
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
        .data-table td, .data-table th {
            padding: var(--space-xs) var(--space-sm);
        }
        
        .actions-cell {
            flex-direction: column;
        }
    }
</style>

@if(session('success'))
    <div class="notification notification-success">
        {{ session('success') }}
    </div>
@endif

<div class="productos-container">
    <div class="productos-header">
        <h1>Gestor de Productos</h1>
        <div class="controls-group">
            <button id="openModal" class="btn btn-primary">
                <i class="fas fa-plus btn-icon"></i>Nuevo Producto
            </button>
            <a href="{{ route('Productos.pdf') }}" class="btn btn-gray" target="_blank">
                <i class="fas fa-file-pdf btn-icon"></i>Exportar PDF
            </a>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Código Barras</th>
                    <th>Código Interno</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th>Stock minimo</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Unidad de medida</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Fecha ultima Venta</th>
                    <th>Fecha Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->codigo_barras }}</td>
                    <td>{{ $producto->codigo_interno }}</td>
                    <td>${{ number_format($producto->precio_compra, 2) }}</td>
                    <td>${{ number_format($producto->precio_venta, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->stock_minimo }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $producto->proveedor->nombre ?? 'Sin Proveedor' }}</td>
                    <td>{{ $producto->unidad_medida }}</td>
                    <td>
                        <span class="badge {{ $producto->activo ? 'badge-active' : 'badge-inactive' }}">
                            {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        @if($producto->imagen)
                            <img src="{{ asset('storage/'.$producto->imagen) }}" class="table-img">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>{{ $producto->fecha_ultima_venta }}</td>
                    <td>{{ $producto->fecha_caducidad }}</td>
                    <td class="actions-cell">
                      
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar este producto?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para crear/editar productos -->
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-content">
            <h2 class="modal-title" id="modalFormTitle">Crear Nuevo Producto</h2>

            <form id="productoForm" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="formMethod"></div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre*</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" required>
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror">
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo_barras" class="form-label">Código de barras*</label>
                        <input type="text" name="codigo_barras" id="codigo_barras" class="form-control @error('codigo_barras') is-invalid @enderror" required>
                        @error('codigo_barras')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo_interno" class="form-label">Código interno</label>
                        <input type="text" name="codigo_interno" id="codigo_interno" class="form-control @error('codigo_interno') is-invalid @enderror">
                        @error('codigo_interno')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="precio_compra" class="form-label">Precio de compra</label>
                        <input type="number" name="precio_compra" id="precio_compra" step="0.01" class="form-control @error('precio_compra') is-invalid @enderror" required>
                        @error('precio_compra')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="precio_venta" class="form-label">Precio de venta</label>
                        <input type="number" name="precio_venta" id="precio_venta" step="0.01" class="form-control @error('precio_venta') is-invalid @enderror" required>
                        @error('precio_venta')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock" class="form-label">Stock*</label>
                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" required>
                        @error('stock')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_minimo" class="form-label">Stock mínimo*</label>
                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control @error('stock_minimo') is-invalid @enderror" required>
                        @error('stock_minimo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria_id" class="form-label">Categoría*</label>
                        <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proveedor_id" class="form-label">Proveedor</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror">
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unidad_medida" class="form-label">Unidad de medida*</label>
                        <select name="unidad_medida" id="unidad_medida" class="form-control @error('unidad_medida') is-invalid @enderror" required>
                            <option value="unidad">Unidad</option>
                            <option value="kg">Kilogramo</option>
                            <option value="g">Gramo</option>
                            <option value="l">Litro</option>
                            <option value="ml">Mililitro</option>
                            <option value="paquete">Paquete</option>
                        </select>
                        @error('unidad_medida')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Estado*</label>
                        <div class="toggle-container">
                            <div class="toggle-switch">
                                <input type="radio" name="activo" id="activo" value="1" checked class="toggle-input">
                                <input type="radio" name="activo" id="inactivo" value="0" class="toggle-input">
                                <label for="activo" class="toggle-option">Activo</label>
                                <label for="inactivo" class="toggle-option">Inactivo</label>
                                <div class="toggle-slider"></div>
                            </div>
                        </div>
                        @error('activo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*">
                        <img id="imagen-preview" class="img-preview" src="" alt="Vista previa" style="display: none;">
                        @error('imagen')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_ultima_venta" class="form-label">Fecha última venta</label>
                        <input type="date" name="fecha_ultima_venta" id="fecha_ultima_venta" class="form-control @error('fecha_ultima_venta') is-invalid @enderror">
                        @error('fecha_ultima_venta')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_caducidad" class="form-label">Fecha de caducidad</label>
                        <input type="date" name="fecha_caducidad" id="fecha_caducidad" class="form-control @error('fecha_caducidad') is-invalid @enderror">
                        @error('fecha_caducidad')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save btn-icon"></i><span id="submit-btn-text">Guardar</span>
                    </button>
                    <button type="button" id="closeModal" class="btn btn-danger">
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
        const openButton = document.getElementById('openModal');
        const closeButton = document.getElementById('closeModal');
        const form = document.getElementById('productoForm');
        const formMethod = document.getElementById('formMethod');
        const modalTitle = document.getElementById('modalFormTitle');
        const submitBtnText = document.getElementById('submit-btn-text');
        const imagenInput = document.getElementById('imagen');
        const imagenPreview = document.getElementById('imagen-preview');
        let currentProductId = null;

        // Abrir modal para crear
        openButton.addEventListener('click', () => {
            form.reset();
            form.action = "{{ route('productos.store') }}";
            formMethod.innerHTML = '';
            modalTitle.textContent = 'Crear Nuevo Producto';
            submitBtnText.textContent = 'Guardar';
            imagenPreview.style.display = 'none';
            currentProductId = null;
            
            // Resetear el toggle switch
            document.getElementById('activo').checked = true;
            document.querySelector('.toggle-slider').style.transform = 'translateX(0)';
            document.querySelector('.toggle-slider').style.backgroundColor = 'var(--primary-color)';
            
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Cerrar modal
        closeButton.addEventListener('click', () => {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Cerrar modal al hacer clic fuera
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Vista previa de imagen
        imagenInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagenPreview.src = e.target.result;
                    imagenPreview.style.display = 'block';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Manejar edición de productos
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                currentProductId = id;

                // Mostrar spinner o indicador de carga
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
                this.disabled = true;
                
                fetch(`/productos/${id}/edit`)
                    .then(response => {
                        if(!response.ok) throw new Error('Error al cargar producto');
                        return response.json();
                    })
                    .then(data => {
                        // Restaurar el botón
                        this.innerHTML = originalContent;
                        this.disabled = false;
                        
                        // Llenar formulario
                        document.getElementById('nombre').value = data.nombre || '';
                        document.getElementById('descripcion').value = data.descripcion || '';
                        document.getElementById('codigo_barras').value = data.codigo_barras || '';
                        document.getElementById('codigo_interno').value = data.codigo_interno || '';
                        document.getElementById('precio_compra').value = data.precio_compra || '';
                        document.getElementById('precio_venta').value = data.precio_venta || '';
                        document.getElementById('stock').value = data.stock || '';
                        document.getElementById('stock_minimo').value = data.stock_minimo || '';
                        document.getElementById('categoria_id').value = data.categoria_id || '';
                        document.getElementById('proveedor_id').value = data.proveedor_id || '';
                        document.getElementById('unidad_medida').value = data.unidad_medida || '';
                        
                        // Formatear fechas para el input date
                        document.getElementById('fecha_ultima_venta').value = data.fecha_ultima_venta ? data.fecha_ultima_venta.split(' ')[0] : '';
                        document.getElementById('fecha_caducidad').value = data.fecha_caducidad ? data.fecha_caducidad.split(' ')[0] : '';

                        // Estado activo/inactivo
                        if(data.activo) {
                            document.getElementById('activo').checked = true;
                            document.querySelector('.toggle-slider').style.transform = 'translateX(0)';
                            document.querySelector('.toggle-slider').style.backgroundColor = 'var(--primary-color)';
                        } else {
                            document.getElementById('inactivo').checked = true;
                            document.querySelector('.toggle-slider').style.transform = 'translateX(100%)';
                            document.querySelector('.toggle-slider').style.backgroundColor = 'var(--danger-color)';
                        }

                        // Configurar formulario para edición
                        form.action = `/productos/${data.id}`;
                        formMethod.innerHTML = '@method("PUT")';
                        modalTitle.textContent = 'Editar Producto';
                        submitBtnText.textContent = 'Actualizar';

                        // Mostrar imagen actual si existe
                        if(data.imagen) {
                            imagenPreview.src = `/storage/${data.imagen}`;
                            imagenPreview.style.display = 'block';
                        } else {
                            imagenPreview.style.display = 'none';
                        }

                        modalOverlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Restaurar el botón
                        this.innerHTML = originalContent;
                        this.disabled = false;
                        alert('Error al cargar los datos del producto');
                    });
            });
        });

        // Auto cerrar notificaciones
        const notification = document.querySelector('.notification');
        if (notification) {
            setTimeout(() => {
                notification.classList.add('notification-fade-out');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Configurar el toggle switch
        function setupToggleSwitch() {
            const toggleInputs = document.querySelectorAll('.toggle-input');
            const slider = document.querySelector('.toggle-slider');

            toggleInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.id === 'inactivo') {
                        slider.style.transform = 'translateX(100%)';
                        slider.style.backgroundColor = 'var(--danger-color)';
                    } else {
                        slider.style.transform = 'translateX(0)';
                        slider.style.backgroundColor = 'var(--primary-color)';
                    }
                });
            });
        }

        setupToggleSwitch();
    });
</script>
@endsection