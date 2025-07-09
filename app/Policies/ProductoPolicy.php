<?php

namespace App\Policies;

use App\Models\productos;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProductoPolicy
{
    /**
     * Determine if the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver la lista
        return true;
    }

    /**
     * Determine if the user can view the product.
     */
    public function view(User $user, productos $producto): bool
    {
        $isOwner = $user->id === $producto->user_id;
        
        if (!$isOwner) {
            Log::warning('Intento de acceso no autorizado a producto', [
                'user_id' => $user->id,
                'product_id' => $producto->id,
                'product_owner' => $producto->user_id
            ]);
        }
        
        return $isOwner;
    }

    /**
     * Determine if the user can create products.
     */
    public function create(User $user): bool
    {
        // Todos los usuarios autenticados pueden crear
        return true;
    }

    /**
     * Determine if the user can update the product.
     */
    public function update(User $user, productos $producto): bool
    {
        $isOwner = $user->id === $producto->user_id;
        
        if (!$isOwner) {
            Log::warning('Intento de edición no autorizado de producto', [
                'user_id' => $user->id,
                'product_id' => $producto->id,
                'product_owner' => $producto->user_id
            ]);
        }
        
        return $isOwner;
    }

    /**
     * Determine if the user can delete the product.
     */
    public function delete(User $user, productos $producto): bool
    {
        $isOwner = $user->id === $producto->user_id;
        
        if (!$isOwner) {
            Log::error('Intento de eliminación no autorizado de producto', [
                'user_id' => $user->id,
                'product_id' => $producto->id,
                'product_owner' => $producto->user_id,
                'time' => now()->toDateTimeString()
            ]);
        }
        
        return $isOwner;
    }

    /**
     * Determine if the user can restore the product.
     * (Opcional para soft deletes)
     */
    public function restore(User $user, productos $producto): bool
    {
        return $user->id === $producto->user_id;
    }

    /**
     * Determine if the user can permanently delete the product.
     * (Opcional para soft deletes)
     */
    public function forceDelete(User $user, productos $producto): bool
    {
        return $user->id === $producto->user_id;
    }
}
