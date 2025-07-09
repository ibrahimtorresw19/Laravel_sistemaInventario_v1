<?php

namespace App\Policies;

use App\Models\User;
use App\Models\almacen;

class AlmacenPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, almacen $almacen): bool
    {
        return $user->id === $almacen->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, almacen $almacen): bool
    {
        return $user->id === $almacen->user_id;
    }

    public function delete(User $user, almacen $almacen): bool
    {
        return $user->id === $almacen->user_id;
    }

    public function restore(User $user, almacen $almacen): bool
    {
        return $user->id === $almacen->user_id;
    }

    public function forceDelete(User $user, Almacen $almacen): bool
    {
        return $user->id === $almacen->user_id;
    }
}
