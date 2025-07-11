<?php

namespace App\Policies;

use App\Models\User;
use App\Models\categorias;

class CategoriaPolicy
{
    /**
     * Determina si el usuario puede ver cualquier categoría
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden ver la lista
    }

    /**
     * Determina si el usuario puede ver una categoría específica
     */
    public function view(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id; // Solo el dueño puede ver
    }

    /**
     * Determina si el usuario puede crear categorías
     */
    public function create(User $user): bool
    {
        return true; // Todos los usuarios autenticados pueden crear
    }

    /**
     * Determina si el usuario puede actualizar una categoría
     */
    public function update(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id; // Solo el dueño puede editar
    }

    /**
     * Determina si el usuario puede eliminar una categoría
     */
    public function delete(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id; // Solo el dueño puede eliminar
    }

    /**
     * Determina si el usuario puede restaurar categorías eliminadas (soft delete)
     */
    public function restore(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id; // Solo el dueño puede restaurar
    }

    /**
     * Determina si el usuario puede eliminar permanentemente categorías
     */
    public function forceDelete(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id; // Solo el dueño puede eliminar permanentemente
    }
}
