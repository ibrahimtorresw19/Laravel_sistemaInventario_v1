<?php

namespace App\Policies;

use App\Models\inventario_fisico;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventarioFisicoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Cualquier usuario autenticado puede ver la lista
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, inventario_fisico $inventario): bool
    {
        // Solo el dueño puede ver el inventario
        return $user->id === $inventario->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear inventarios
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, inventario_fisico $inventario): bool
    {
        // Solo el dueño puede editar el inventario
        return $user->id === $inventario->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, inventario_fisico $inventario): bool
    {
        // Solo el dueño puede eliminar el inventario
        return $user->id === $inventario->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, inventario_fisico $inventario): bool
    {
        // Solo el dueño puede restaurar (si usas soft deletes)
        return $user->id === $inventario->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, inventario_fisico $inventario): bool
    {
        // Solo el dueño puede eliminar permanentemente
        return $user->id === $inventario->user_id;
    }
}
