<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class ProductosVariaciones extends Model
{
    use HasFactory;
    protected $primaryKey = 'variacion_producto_id';
 
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'variacion_producto_id',
        'producto_id', 
        'referencia', 
        'precio', 
        'descripcion', 
    ];

    protected $table = 'productos_variaciones';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->variacion_producto_id = (string) Uuid::generate(4); 
        });
    }

    public function productos()
    {
        return $this->hasOne('App\Models\Productos', 'producto_id', 'producto_id');
    }
}
