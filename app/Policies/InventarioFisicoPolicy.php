<?php

namespace App\Policies;

use App\Models\Inventario_Fisico;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventarioFisicoPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier registro de inventario físico.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden ver la lista
    }

    /**
     * Determinar si el usuario puede ver un inventario físico específico.
     */
    public function view(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    /**
     * Determinar si el usuario puede crear nuevos registros de inventario físico.
     */
    public function create(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden crear
    }

    /**
     * Determinar si el usuario puede actualizar un inventario físico.
     */
    public function update(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    /**
     * Determinar si el usuario puede eliminar un inventario físico.
     */
    public function delete(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    /**
     * Determinar si el usuario puede realizar conteos físicos en el inventario.
     */
    public function realizarConteo(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id;
    }

    /**
     * Determinar si el usuario puede cerrar un inventario físico.
     */
    public function cerrarInventario(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id && $inventario->estado !== 'cerrado';
    }

    /**
     * Determinar si el usuario puede reabrir un inventario físico cerrado.
     */
    public function reabrirInventario(User $user, Inventario_Fisico $inventario): bool
    {
        return $user->id === $inventario->user_id && $inventario->estado === 'cerrado';
    }
}