@extends('principal')

@section('title', 'Dashboard de Inventario')

@section('styles')
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --purple-color: #9b59b6;
        --dark-color: #34495e;
        --light-color: #ecf0f1;
        --gray-color: #95a5a6;
        --border-radius: 10px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .dashboard-container {
        padding: 2rem 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .dashboard-header {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .dashboard-title {
        color: var(--dark-color);
        font-size: 2rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
        position: relative;
        display: inline-block;
    }

    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 3px;
    }

    .dashboard-subtitle {
        color: var(--gray-color);
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        text-align: center;
        transition: var(--transition);
        border-left: 5px solid var(--primary-color);
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: var(--primary-color);
    }

    .metric-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    .metric-card.products {
        border-left-color: var(--secondary-color);
    }
    .metric-card.products::before {
        background: var(--secondary-color);
    }

    .metric-card.warehouse {
        border-left-color: var(--warning-color);
    }
    .metric-card.warehouse::before {
        background: var(--warning-color);
    }

    .metric-card.suppliers {
        border-left-color: var(--purple-color);
    }
    .metric-card.suppliers::before {
        background: var(--purple-color);
    }

    .metric-card.inventory {
        border-left-color: var(--danger-color);
    }
    .metric-card.inventory::before {
        background: var(--danger-color);
    }

    .metric-card.movements {
        border-left-color: #1abc9c;
    }
    .metric-card.movements::before {
        background: #1abc9c;
    }

    .metric-icon {
        font-size: 2.2rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
        transition: var(--transition);
    }

    .metric-card:hover .metric-icon {
        transform: scale(1.1);
    }

    .metric-card.products .metric-icon {
        color: var(--secondary-color);
    }

    .metric-card.warehouse .metric-icon {
        color: var(--warning-color);
    }

    .metric-card.suppliers .metric-icon {
        color: var(--purple-color);
    }

    .metric-card.inventory .metric-icon {
        color: var(--danger-color);
    }

    .metric-card.movements .metric-icon {
        color: #1abc9c;
    }

    .metric-title {
        color: var(--gray-color);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .metric-value {
        color: var(--dark-color);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        transition: var(--transition);
    }

    .metric-card:hover .metric-value {
        color: var(--primary-color);
    }

    .metric-card.products:hover .metric-value {
        color: var(--secondary-color);
    }

    .metric-card.warehouse:hover .metric-value {
        color: var(--warning-color);
    }

    .metric-card.suppliers:hover .metric-value {
        color: var(--purple-color);
    }

    .metric-card.inventory:hover .metric-value {
        color: var(--danger-color);
    }

    .metric-card.movements:hover .metric-value {
        color: #1abc9c;
    }

    .metric-description {
        color: var(--gray-color);
        font-size: 0.85rem;
        line-height: 1.4;
        margin-bottom: 0;
    }

    .metric-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 1;
    }

    /* Efecto de onda al hacer clic */
    .metric-card {
        position: relative;
        overflow: hidden;
    }

    .metric-card .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(2.5);
            opacity: 0;
        }
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1.5rem 1rem;
        }

        .dashboard-title {
            font-size: 1.7rem;
        }

        .metrics-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.2rem;
        }

        .metric-card {
            padding: 1.2rem;
        }

        .metric-value {
            font-size: 1.6rem;
        }

        .metric-icon {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .metrics-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .dashboard-title {
            font-size: 1.5rem;
        }

        .metric-card {
            padding: 1rem;
        }

        .metric-value {
            font-size: 1.4rem;
        }

        .metric-icon {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
    }

    @media (max-width: 400px) {
        .metrics-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 1.4rem;
        }

        .metric-title {
            font-size: 0.9rem;
        }

        .metric-value {
            font-size: 1.3rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Resumen de Inventario</h1>
        <p class="dashboard-subtitle">Vista general de las métricas clave de tu sistema de inventario</p>
    </div>

    <div class="metrics-grid">
        <!-- Tarjeta de Categorías -->
        <div class="metric-card">
            <a href="{{ route('categorias') }}" class="metric-link" id="metric-categorias"></a>
            <div class="metric-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h3 class="metric-title">Categorías</h3>
            <p class="metric-value">{{ number_format($Countcategorias) }}</p>
            <p class="metric-description">Total de categorías registradas</p>
        </div>

        <!-- Tarjeta de Productos -->
        <div class="metric-card products">
            <a href="{{ route('productos.index') }}" class="metric-link" id="metric-productos"></a>
            <div class="metric-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <h3 class="metric-title">Productos</h3>
            <p class="metric-value">{{ number_format($CountProductos) }}</p>
            <p class="metric-description">Productos en inventario</p>
        </div>

        <!-- Tarjeta de Almacén -->
        <div class="metric-card warehouse">
            <a href="{{ route('almacen.index') }}" class="metric-link" id="metric-almacenes"></a>
            <div class="metric-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <h3 class="metric-title">Almacenes</h3>
            <p class="metric-value">{{ number_format($CountAlmacen) }}</p>
            <p class="metric-description">Ubicaciones disponibles</p>
        </div>

        <!-- Tarjeta de Proveedores -->
        <div class="metric-card suppliers">
            <a href="{{ route('proveedores.index') }}" class="metric-link" id="metric-proveedores"></a>
            <div class="metric-icon">
                <i class="fas fa-truck"></i>
            </div>
            <h3 class="metric-title">Proveedores</h3>
            <p class="metric-value">{{ number_format($Countproveedores) }}</p>
            <p class="metric-description">Proveedores activos</p>
        </div>

        <!-- Tarjeta de Inventario Físico -->
        <div class="metric-card inventory">
            <a href="{{ route('inventarioFisico') }}" class="metric-link" id="metric-inventarios"></a>
            <div class="metric-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h3 class="metric-title">Inventario Físico</h3>
            <p class="metric-value">{{  $CountInventarioFisico  }}</p>
            <p class="metric-description">Conteos físicos realizados</p>
        </div>

        <!-- Tarjeta de Movimientos -->
        <div class="metric-card movements">
            <a href="{{ route('movimientos.index') }}" class="metric-link" id="metric-movimientos"></a>
            <div class="metric-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <h3 class="metric-title">Movimientos</h3>
            <p class="metric-value">{{  $CountMovimiento}}</p>
            <p class="metric-description">Transacciones registradas</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard de inventario cargado');

        // Animación de entrada para las tarjetas
        const cards = document.querySelectorAll('.metric-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';

            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 150 * index);
        });

        // Efecto ripple para las tarjetas
        const metricLinks = document.querySelectorAll('.metric-link');
        metricLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = e.currentTarget.getAttribute('href');
                
                // Crear efecto ripple
                const rect = e.currentTarget.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                e.currentTarget.appendChild(ripple);
                
                // Redirigir después de la animación
                setTimeout(() => {
                    window.location.href = target;
                }, 600);
            });
        });

        // Actualización periódica de métricas (opcional)
        if (typeof updateMetrics === 'undefined') {
            setInterval(() => {
                fetch('/api/dashboard-metrics')
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#metric-categorias + .metric-value').textContent = data.categorias;
                        document.querySelector('#metric-productos + .metric-value').textContent = data.productos;
                        // Actualizar otras métricas...
                    })
                    .catch(error => console.error('Error al actualizar métricas:', error));
            }, 300000); // Actualizar cada 5 minutos
        }
    });
</script>
@endsection