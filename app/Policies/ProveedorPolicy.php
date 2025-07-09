<?php

namespace App\Policies;

use App\Models\proveedor;
use App\Models\User;

class ProveedorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    public function delete(User $user, proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    // Método adicional para relacionar proveedores con productos
    public function asociarProductos(User $user, proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }
}
