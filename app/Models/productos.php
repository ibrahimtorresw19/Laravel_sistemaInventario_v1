<?php

namespace App\Models;

use App\Models\Categorias;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\UserScope;
use Illuminate\Support\Facades\Auth;

class Productos extends Model
{
    use HasFactory, SoftDeletes;

      protected $table = 'productos';
      
    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo_barras',
        'codigo_interno',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'categoria_id',
        'proveedor_id',
        'unidad_medida',
        'activo',
        'imagen',
        'fecha_ultima_venta',
        'fecha_caducidad',
        'user_id'
    ];

    protected $casts = [
        'fecha_caducidad' => 'date',
        'activo' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoDeInventario::class);
    }

    public function inventariosFisicos()
    {
        return $this->belongsToMany(InventarioFisico::class, 'inventario_fisico_detalles')
                    ->withPivot(['almacen_id', 'cantidad_sistema', 'cantidad_fisica', 'diferencia']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);

        static::creating(function ($model) {
            $model->user_id = $model->user_id ?? Auth::id();
        });

        static::updating(function ($model) {
            if ($model->isDirty('user_id') && $model->getOriginal('user_id') !== Auth::id()) {
                throw new \Illuminate\Auth\Access\AuthorizationException(
                    'No tienes permiso para cambiar el propietario de este producto'
                );
            }
        });
    }

    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}