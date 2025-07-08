<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\UserScope;
use Illuminate\Support\Facades\Auth;

class Categorias extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'user_id'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function productos()
    {
        return $this->hasMany(Productos::class, 'categoria_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);

        // Asignación automática del usuario al crear
        static::creating(function ($model) {
            $model->user_id = $model->user_id ?? Auth::id();
        });

        // Validación adicional para operaciones de actualización
        static::updating(function ($model) {
            if ($model->isDirty('user_id') && $model->getOriginal('user_id') !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para cambiar el propietario de esta categoría'
                );
            }
        });
    }

    /**
     * Método para forzar el uso del scope en consultas
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}