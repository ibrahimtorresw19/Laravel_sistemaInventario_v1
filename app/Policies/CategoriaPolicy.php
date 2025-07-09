<?php

namespace App\Policies;

use App\Models\categorias;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriaPolicy
{
    /**
     * Determine whether the user can view any models.
     * (Ver lista de categorías)
     */
    public function viewAny(User $user): bool
    {
        // El Global Scope (UserScope) ya filtra por usuario
        // Aquí solo verificamos que esté autenticado
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     * (Ver una categoría específica)
     */
    public function view(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede ver la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can create models.
     * (Mostrar formulario de creación)
     */
    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear categorías
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     * (Editar una categoría)
     */
    public function update(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede editar la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * (Eliminar una categoría)
     */
    public function delete(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede eliminar la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     * (Restaurar categoría eliminada con soft delete)
     */
    public function restore(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede restaurar la categoría
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * (Eliminación permanente, sin soft delete)
     */
    public function forceDelete(User $user, categorias $categoria): bool
    {
        // Solo el dueño puede eliminar permanentemente
        return $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can reorder models.
     * (Si tienes funcionalidad de reordenar categorías)
     */
    public function reorder(User $user): bool
    {
        // Solo usuarios autenticados pueden reordenar SUS categorías
        // El scope global asegura que solo afecte a las suyas
        return $user !== null;
    }
}
