<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Almacen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'almacenes';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'capacidad',
        'activo',
        'user_id'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


public function almacenes()
{
    return $this->hasMany(Almacen::class);
}
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = $model->user_id ?? Auth::id();
        });

        static::updating(function ($model) {
            if ($model->isDirty('user_id') && $model->getOriginal('user_id') !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para cambiar el propietario de este almacén'
                );
            }
        });
    }

   
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}
   
