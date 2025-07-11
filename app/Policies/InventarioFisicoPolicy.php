<?php

namespace App\Policies;

use App\Models\User;
use App\Models\inventario_fisico;

class InventarioFisicoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function delete(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function restore(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function forceDelete(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function realizarConteo(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    public function cerrarInventario(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id && $inventario->estado !== 'cerrado';
    }

    public function reabrirInventario(User $user, inventario_fisico $inventario): bool
    {
        return $user->id === $inventario->user_id && $inventario->estado === 'cerrado';
    }
}
