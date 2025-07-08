<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Sistema de Inventario</title>
    <style>
        :root {
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --content-bg: #f1f5f9;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--content-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #334155;
            line-height: 1.5;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--text-light);
            height: 100vh;
            position: fixed;
            padding: 0;
            transition: var(--transition);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .user-profile {
            padding: 1.5rem;
            text-align: center;
            background: linear-gradient(to bottom, rgba(30, 41, 59, 0.9), rgba(30, 41, 59, 0.7));
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #3b82f6;
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-role {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0;
            scrollbar-width: thin;
            scrollbar-color: var(--sidebar-active) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: var(--sidebar-active);
            border-radius: 3px;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .nav-link {
            color: var(--text-light);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: var(--transition);
            margin: 0.1rem 0;
            font-size: 0.95rem;
            font-weight: 500;
            position: relative;
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            padding-left: 1.75rem;
            color: white;
        }

        .nav-link.active {
            background-color: var(--sidebar-active);
            color: white;
            box-shadow: inset 3px 0 0 white;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            right: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background-color: var(--sidebar-active);
            border-radius: 4px;
            rotate: 45deg;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            transition: var(--transition);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            padding: 1rem;
            background-color: var(--sidebar-bg);
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1100;
        }

        .mobile-menu-toggle i {
            transition: var(--transition);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1100;
            }

            body.sidebar-active {
                overflow: hidden;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }

            .user-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .user-name {
                font-size: 1rem;
            }

            .nav-link {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
            }

            .mobile-menu-toggle.active i {
                transform: rotate(90deg);
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- User Profile Section -->
        <div class="user-profile">
            <div class="user-avatar" style="background-image: url('{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar) : '' }}')">
                @if(!Auth::user()->avatar)
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">Usuario</div>
        </div>

        <!-- Main Menu -->
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menú Principal</div>
                <a href="/inicio" class="nav-link {{ request()->is('inicio') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
                <a href="/productos" class="nav-link {{ request()->is('producto') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i>
                    <span>Productos</span>
                </a>
                <a href="/Categorias" class="nav-link {{ request()->is('Categorias') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Categorías</span>
                </a>
                <a href="/proveedores" class="nav-link {{ request()->is('Proveedor') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span>Proveedores</span>
                </a>
                <a href="/almacen" class="nav-link {{ request()->is('almacen') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i>
                    <span>Almacenes</span>
                </a>
                <a href="/inventarioFisico" class="nav-link {{ request()->is('inventarioFisico') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inventario Físico</span>
                </a>
                <a href="/MovimientoDeInventario" class="nav-link {{ request()->is('MoviminetoDeInventario') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Movimientos</span>
                </a>
            </div>

            <!-- User Options -->
            <div class="nav-section">
                <div class="nav-section-title">Configuración</div>
                <a href="/perfil" class="nav-link {{ request()->is('perfil') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Información del Usuario</span>
                </a>
                <a href="/Informacion-de-empresa" class="nav-link {{ request()->is('Informacion-de-empresa') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span>Información de la Empresa</span>
                </a>
                <a href="/empresa" class="nav-link {{ request()->is('empresa') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>Empresa</span>
                </a>
                <a href="/cambio-de-clave" class="nav-link {{ request()->is('cambio-de-clave') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>Cambiar Contraseña</span>
                </a>
                <a href="/cerrar_sesion" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                menuToggle.classList.toggle('active');
                body.classList.toggle('sidebar-active');
            });

            // Cerrar el menú al hacer clic en un enlace en dispositivos móviles
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                        menuToggle.classList.remove('active');
                        body.classList.remove('sidebar-active');
                    }
                });
            });

            // Cerrar el menú al hacer clic fuera de él
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992 &&
                    !sidebar.contains(event.target) &&
                    event.target !== menuToggle &&
                    !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                    menuToggle.classList.remove('active');
                    body.classList.remove('sidebar-active');
                }
            });

            // Escuchar eventos de actualización de avatar
            window.addEventListener('avatarUpdated', function(e) {
                const avatar = document.querySelector('.user-avatar');
                avatar.style.backgroundImage = `url(${e.detail.avatarUrl}?${new Date().getTime()})`;
                avatar.textContent = '';
            });
        });
    </script>

    @yield('scripts')
</body>
</html>