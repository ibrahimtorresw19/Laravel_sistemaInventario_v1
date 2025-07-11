<?php

namespace App\Policies;

use App\Models\categorias;
use App\Models\User;

class CategoriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede ver cualquier categoría.
     */
    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determina si el usuario puede ver una categoría específica.
     */
    public function view(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id;
    }

    /**
     * Determina si el usuario puede crear categorías.
     */
    public function create(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determina si el usuario puede actualizar una categoría.
     */
    public function update(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id;
    }

    /**
     * Determina si el usuario puede eliminar una categoría.
     */
    public function delete(User $user, categorias $categoria): bool
    {
        return $user->id === $categoria->user_id;
    }
}
