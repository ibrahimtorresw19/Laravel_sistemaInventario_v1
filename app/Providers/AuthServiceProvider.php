<?php

namespace App\Providers;

use App\Models\almacen;
use App\Models\categorias;
use App\Models\inventario_fisico;
use App\Models\movimiento_de_inventario;
use App\Models\productos;
use App\Models\proveedor;
use App\Models\EmpresaModel;
use App\Policies\AlmacenPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\InventarioFisicoPolicy;
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
        categorias::class => CategoriaPolicy::class,
        proveedor::class => ProveedorPolicy::class,
        inventario_fisico::class => InventarioFisicoPolicy::class,
        productos::class => ProductoPolicy::class,
        movimiento_de_inventario::class => MovimientoPolicy::class,
            almacen::class => AlmacenPolicy::class,
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
