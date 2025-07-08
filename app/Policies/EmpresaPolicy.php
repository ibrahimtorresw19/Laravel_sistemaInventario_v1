<?php

namespace App\Policies;

use App\Models\EmpresaModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmpresaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, EmpresaModel $empresa)
    {
        return $user->id === $empresa->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, EmpresaModel $empresa)
    {
        return $user->id === $empresa->user_id;
    }

    public function delete(User $user, EmpresaModel $empresa)
    {
        return $user->id === $empresa->user_id;
    }

    public function restore(User $user, EmpresaModel $empresa)
    {
        return $user->id === $empresa->user_id;
    }

    public function forceDelete(User $user, EmpresaModel $empresa)
    {
        return $user->id === $empresa->user_id;
    }
}