@extends('principal')

@section('content')
<style>
    /* Estilos generales */
    .container-xxl {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Tarjeta principal */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    /* Encabezado de la tarjeta */
    .card-header {
        padding: 1.5rem 2rem;
        border-bottom: none;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .card-header h2 {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .badge {
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        color: #fff;
    }

    .badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Cuerpo de la tarjeta */
    .card-body {
        padding: 2rem;
        background-color: #f8fafc;
    }

    /* Alertas */
    .alert {
        border-radius: 8px;
        border-left: 4px solid;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .alert-success {
        border-left-color: #1cc88a;
        background-color: rgba(28, 200, 138, 0.1);
    }

    /* Secciones del formulario */
    section {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        border: 1px solid #e9ecef;
    }

    section h5 {
        font-weight: 600;
        color: #4e73df;
        display: flex;
        align-items: center;
    }

    section h5 i {
        font-size: 1.1em;
    }

    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }

    /* Campos de formulario */
    .form-floating {
        margin-bottom: 1rem;
    }

    .form-floating label {
        color: #6c757d;
        font-weight: 500;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 1rem 1rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        box-shadow: none;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #e74a3b;
    }

    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(231, 74, 59, 0.25);
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    /* Texto de ayuda */
    .form-text {
        color: #6c757d;
        font-size: 0.85rem;
    }

    /* Botones */
    .btn {
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2);
    }

    .btn-primary:hover {
        background-color: #3a5bc7;
        border-color: #3a5bc7;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(78, 115, 223, 0.3);
    }

    .btn-outline-secondary {
        border-color: #e0e0e0;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #d1d3e2;
        color: #5a5c69;
    }

    /* Sección del logo */
    .img-thumbnail {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.25rem;
        transition: transform 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
    }

    /* Tarjeta de recomendaciones */
    .bg-light {
        background-color: #f8fafc !important;
        border-radius: 10px;
    }

    .card-title {
        font-weight: 600;
        color: #5a5c69;
    }

    .list-unstyled li {
        padding: 0.25rem 0;
        color: #6c757d;
    }

    .mb-0{
        color:#fff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        section {
            padding: 1.25rem;
        }
    }

    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card, section {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Efecto para los campos requeridos */
    .form-floating label span.text-danger {
        position: relative;
        margin-left: 2px;
    }

    .form-floating label span.text-danger::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #e74a3b;
        opacity: 0.7;
        border-radius: 2px;
    }

    /* Estilo para el área de texto */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
</style>

<div class="container-xxl py-4">
    <div class="card shadow-lg">
        <!-- Encabezado de la tarjeta -->
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="h4 mb-0">
                    <i class="fas fa-building me-2"></i>Información de la Empresa
                </h2>
                <div class="badge bg-white text-primary rounded-pill px-3 py-2">
                    <i class="fas fa-cog me-1"></i> Configuración
                </div>
            </div>
        </div>

        <!-- Cuerpo de la tarjeta -->
        <div class="card-body p-4">
            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Formulario principal -->
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate action="{{ route('Infoempresa.store') }}">
                @csrf


                <!-- Sección: Información Básica -->
                <section class="mb-5">
                    <h5 class="text-primary mb-3 border-bottom pb-2">
                        <i class="fas fa-info-circle me-2"></i>Información Básica
                    </h5>

                    <div class="row g-3">
                        <!-- Nombre de la empresa -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Nombre de la Empresa"
                                    value="{{ old('nombre', $empresa->nombre ?? '') }}"
                                    required>
                                <label for="nombre">
                                    Nombre de la Empresa <span class="text-danger">*</span>
                                </label>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- RUC -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('ruc') is-invalid @enderror"
                                    id="ruc"
                                    name="RUC"
                                    placeholder="RUC"
                                    value="{{ old('ruc', $empresa->ruc ?? '') }}"
                                    required>
                                <label for="ruc">
                                    RUC <span class="text-danger">*</span>
                                </label>
                                @error('ruc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección: Información de Contacto -->
                <section class="mb-5">
                    <h5 class="text-primary mb-3 border-bottom pb-2">
                        <i class="fas fa-address-book me-2"></i> Información de Contacto
                    </h5>

                    <div class="row g-3">
                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('telefono') is-invalid @enderror"
                                    id="telefono"
                                    name="telefono"
                                    placeholder="Teléfono"
                                    value="{{ old('telefono', $empresa->telefono ?? '') }}">
                                <label for="telefono">Teléfono</label>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    placeholder="Email"
                                    value="{{ old('email', $empresa->email ?? '') }}">
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('direccion') is-invalid @enderror"
                                    id="direccion"
                                    name="direccion"
                                    placeholder="Dirección"
                                    value="{{ old('direccion', $empresa->direccion ?? '') }}">
                                <label for="direccion">Dirección</label>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección: Detalles Adicionales -->
                <section class="mb-5">
                    <h5 class="text-primary mb-3 border-bottom pb-2">
                        <i class="fas fa-building-circle-check me-2"></i> Detalles Adicionales
                    </h5>
                    <div class="row g-3">
                        <!-- Industria -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('industria') is-invalid @enderror"
                                    id="Industria"
                                    name="Industria"
                                    placeholder="Industria"
                                    value="{{ old('industria', $empresa->industria ?? '') }}">
                                <label for="industria">Industria</label>
                                @error('industria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Representante Legal -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control @error('representante') is-invalid @enderror"
                                    id="representante"
                                    name="representante_legal"
                                    placeholder="Representante Legal"
                                    value="{{ old('representante', $empresa->representante ?? '') }}">
                                <label for="representante">Representante Legal</label>
                                @error('representante')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de Fundación -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date"
                                    class="form-control @error('fecha_fundacion') is-invalid @enderror"
                                    id="fecha_fundacion"
                                    name="fecha_fundacion"
                                    placeholder="Fecha de Fundación"
                                    value="{{ old('fecha_fundacion', $empresa->fecha_fundacion ?? '') }}">
                                <label for="fecha_fundacion">Fecha de Fundación</label>
                                @error('fecha_fundacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Moneda Principal (Versión mejorada) -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select @error('moneda_principal') is-invalid @enderror"
                                        id="moneda_principal"
                                        name="moneda"
                                        required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="USD" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'USD' ? 'selected' : '' }}>
                                        USD - Dólar Estadounidense
                                    </option>
                                    <option value="EUR" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'EUR' ? 'selected' : '' }}>
                                        EUR - Euro
                                    </option>
                                    <option value="MXN" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'MXN' ? 'selected' : '' }}>
                                        MXN - Peso Mexicano
                                    </option>
                                    <option value="PEN" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'PEN' ? 'selected' : '' }}>
                                        PEN - Sol Peruano
                                    </option>
                                    <option value="COP" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'COP' ? 'selected' : '' }}>
                                        COP - Peso Colombiano
                                    </option>
                                    <option value="CLP" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'CLP' ? 'selected' : '' }}>
                                        CLP - Peso Chileno
                                    </option>
                                    <option value="ARS" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'ARS' ? 'selected' : '' }}>
                                        ARS - Peso Argentino
                                    </option>
                                    <option value="BRL" {{ old('moneda_principal', $empresa->moneda_principal ?? '') == 'BRL' ? 'selected' : '' }}>
                                        BRL - Real Brasileño
                                    </option>
                                    <option value="other">Otra moneda</option>
                                </select>
                                <label for="moneda_principal">
                                    Moneda Principal <span class="text-danger">*</span>
                                </label>
                                @error('moneda_principal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <!-- Descripción -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                        id="descripcion"
                                        name="descripcion_de_la_empresa"
                                        placeholder="Descripción de la Empresa"
                                        style="height: 100px">{{ old('descripcion', $empresa->descripcion ?? '') }}</textarea>
                                <label for="descripcion">Descripción de la Empresa</label>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección: Logo de la Empresa -->
                <section class="mb-5">
                    <h5 class="text-primary mb-3 border-bottom pb-2">
                        <i class="fas fa-image me-2"></i>Logo de la Empresa
                    </h5>

                    <div class="row g-3">
                        <!-- Subir logo -->
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Subir nuevo logo</label>
                                        <input type="file"
                                            class="form-control @error('logo') is-invalid @enderror"
                                            id="logo"
                                            name="imagen"
                                            accept="image/*">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Formatos aceptados: JPG, PNG, SVG. Tamaño máximo: 2MB
                                        </div>
                                    </div>

                                    @if(isset($empresa->logo) && $empresa->logo)
                                        <div class="d-flex align-items-center mt-3">
                                            <div class="me-3">
                                                <img src="{{ asset('storage/' . $empresa->logo) }}"
                                                    alt="Logo actual"
                                                    class="img-thumbnail"
                                                    style="max-height: 80px;">
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    id="eliminar_logo"
                                                    name="eliminar_logo">
                                                <label class="form-check-label" for="eliminar_logo">
                                                    Eliminar logo actual
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Recomendaciones -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">
                                        <i class="fas fa-lightbulb me-2"></i>Recomendaciones
                                    </h6>
                                    <ul class="list-unstyled small">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Usa una imagen cuadrada para mejor resultado
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            El fondo transparente es ideal
                                        </li>
                                        <li>
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Resolución mínima recomendada: 200x200px
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between align-items-center border-top pt-4">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="window.location.reload();">
                        <i class="fas fa-undo me-2"></i> Descartar Cambios
                    </button>

                    <div>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Guardar Configuración
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del RUC (solo números, máximo 11 dígitos)
        const rucInput = document.getElementById('ruc');
        if (rucInput) {
            rucInput.addEventListener('input', function(e) {
                let ruc = e.target.value.replace(/\D/g, '');
                if (ruc.length > 11) ruc = ruc.substring(0, 11);
                e.target.value = ruc;
            });
        }

        // Validación del teléfono (solo números)
        const telefonoInput = document.getElementById('telefono');
        if (telefonoInput) {
            telefonoInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Vista previa del logo
        const logoInput = document.getElementById('logo');
        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Validación de tamaño
                if (file.size > 2 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. El tamaño máximo permitido es 2MB.');
                    e.target.value = '';
                    return;
                }

                // Crear vista previa
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewContainer = e.target.closest('.card-body');
                    let preview = previewContainer.querySelector('.img-thumbnail');

                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = "img-thumbnail mt-3";
                        preview.style.maxHeight = "80px";
                        previewContainer.insertBefore(preview, previewContainer.querySelector('.form-check'));
                    }

                    preview.src = event.target.result;
                    preview.alt = "Vista previa del nuevo logo";
                };
                reader.readAsDataURL(file);
            });
        }

        // Control para mostrar/ocultar campo de otra moneda
        const monedaSelect = document.getElementById('moneda_principal');
        const otraMonedaContainer = document.getElementById('otra_moneda_container');

        if (monedaSelect && otraMonedaContainer) {
            monedaSelect.addEventListener('change', function() {
                otraMonedaContainer.style.display = this.value === 'other' ? 'block' : 'none';

                // Limpiar campo si no es "other"
                if (this.value !== 'other') {
                    document.getElementById('otra_moneda').value = '';
                }
            });
        }

        // Convertir a mayúsculas automáticamente
        const otraMonedaInput = document.getElementById('otra_moneda');
        if (otraMonedaInput) {
            otraMonedaInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Validación de formulario con Bootstrap
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();
    });
</script>
@endpush
