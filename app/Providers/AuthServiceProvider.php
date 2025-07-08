<?php

namespace App\Providers;

use App\Models\Almacen;
use App\Models\Categorias;
use App\Models\inventario_fisico;
use App\Models\Movimiento_de_Inventario;
use App\Models\Productos;
use App\Models\Proveedor;
use App\Models\EmpresaModel;
use App\Policies\AlmacenPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\inventarioFisicoPolicy;
use App\Policies\MovimientoPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\ProveedorPolicy;
use App\Policies\EmpresaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categorias::class => CategoriaPolicy::class,
        Proveedor::class => ProveedorPolicy::class,
        inventario_fisico::class => inventarioFisicoPolicy::class,
        Productos::class => ProductoPolicy::class,
        movimiento_de_Inventario::class => MovimientoPolicy::class,
            Almacen::class => AlmacenPolicy::class,
        EmpresaModel::class => EmpresaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definición de gates adicionales (si son necesarios)
        // Gate::define('view-reports', function ($user) {
        //     return $user->isAdmin();
        // });
    }
}