<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Movimiento_de_Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movimiento_de_inventario'; // Mantenemos el nombre de tabla en minúsculas

    protected $fillable = [
        'tipo', 
        'cantidad', 
        'producto_id', 
        'almacen_id',
        'user_id',
        'motivo', 
        'responsable', 
        'fecha_movimiento'
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime'
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        // Asignación automática del usuario al crear
        static::creating(function ($model) {
            $model->user_id = $model->user_id ?? Auth::id();
        });

        // Validación para operaciones de actualización
        static::updating(function ($model) {
            if ($model->isDirty('user_id') && $model->getOriginal('user_id') !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para cambiar el propietario de este movimiento'
                );
            }
        });

        // Validación para operaciones de eliminación
        static::deleting(function ($model) {
            if ($model->user_id !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para eliminar este movimiento'
                );
            }
        });
    }
}