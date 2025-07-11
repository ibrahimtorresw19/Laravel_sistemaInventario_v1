<?php

namespace App\Policies;

use App\Models\categorias;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Verifica que el usuario esté autenticado y activo
        return $user !== null && $user->activo;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, categorias $categoria): bool
    {
        // Verifica propiedad y que la categoría exista
        return $categoria && $user->id === $categoria->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Usuario debe estar autenticado y tener permiso de creación
        return $user !== null && $user->hasPermissionTo('create categorias');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, categorias $categoria): bool
    {
        // Verifica propiedad y permisos específicos
        return $categoria && 
               $user->id === $categoria->user_id && 
               $user->hasPermissionTo('edit categorias');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, categorias $categoria): bool
    {
        // Verifica propiedad y que la categoría no tenga relaciones
        return $categoria && 
               $user->id === $categoria->user_id &&
               $categoria->productos()->count() === 0 &&
               $user->hasPermissionTo('delete categorias');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, categorias $categoria): bool
    {
        // Verifica propiedad y permisos para restaurar
        return $categoria && 
               $user->id === $categoria->user_id &&
               $user->hasPermissionTo('restore categorias');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, categorias $categoria): bool
    {
        // Solo administradores pueden eliminar permanentemente
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can reorder models.
     */
    public function reorder(User $user): bool
    {
        // Permiso para reordenar categorías
        return $user->hasPermissionTo('reorder categorias');
    }
}
