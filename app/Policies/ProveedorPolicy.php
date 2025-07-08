<?php

namespace App\Policies;

use App\Models\Proveedor;
use App\Models\User;

class ProveedorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    public function delete(User $user, Proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }

    // Método adicional para relacionar proveedores con productos
    public function asociarProductos(User $user, Proveedor $proveedor): bool
    {
        return $user->id === $proveedor->user_id;
    }
}