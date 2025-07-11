<?php

namespace App\Policies;

use App\Models\categorias;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Cualquier usuario autenticado puede ver la lista de categorías
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede ver la categoría específica
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear categorías
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede editar la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede eliminar la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede restaurar categorías eliminadas (soft deletes)
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede eliminar permanentemente la categoría
        return $user->id === $categoria->user_id;
    }
}
