<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Productos extends Model
{
    use HasFactory;

    protected $primaryKey = 'producto_id';
 
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'producto_id', 
        'referencia_precio', 
        'cantidad', 
        'descripcion', 
        'ruta_imagen_producto', 
        'activo' 
    ];

    protected $table = 'productos';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->producto_id = (string) Uuid::generate(4); 
        });
    }

    public function productos_variaciones()
    {
        return $this->hasMany('App\Models\ProductosVariaciones', 'producto_id', 'producto_id');
    }
}
