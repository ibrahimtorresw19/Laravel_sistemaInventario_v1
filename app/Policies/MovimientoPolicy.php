<?php

namespace App\Policies;

use App\Models\User;
use App\Models\movimiento_de_inventario;

class MovimientoPolicy
{
    public function viewAny(User $user)
    {
        return true; // Todos los usuarios autenticados pueden ver la lista
    }

    public function view(User $user, movimiento_de_inventario $movimiento)
    {
        return $user->id === $movimiento->user_id;
    }

    public function create(User $user)
    {
        return true; // Todos los usuarios autenticados pueden crear
    }

    public function update(User $user, movimiento_de_inventario $movimiento)
    {
        return $user->id === $movimiento->user_id;
    }

    public function delete(User $user, movimiento_de_inventario $movimiento)
    {
        return $user->id === $movimiento->user_id;
    }
}
