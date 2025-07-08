<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\UserScope; // Añade esta línea

class EmpresaModel extends Model
{
    protected $table = 'empresa';
    protected $fillable = [
        'nombre', 'RUC', 'telefono', 'email', 'direccion', 
        'Industria', 'representante_legal', 'fecha_fundacion',
        'moneda', 'descripcion_de_la_empresa', 'imagen', 'user_id'
    ];

    protected $casts = [
        'fecha_fundacion' => 'datetime'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);

        static::creating(function ($model) {
            $model->user_id = $model->user_id ?? Auth::id();
        });

        static::updating(function ($model) {
            if ($model->isDirty('user_id') && $model->getOriginal('user_id') !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para cambiar el propietario de esta empresa'
                );
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}