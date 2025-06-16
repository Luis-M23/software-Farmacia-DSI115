<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'categoria_id', 'presentacion', 'proveedor',
        'precio_compra', 'precio_venta', 'existencia_inicial',
        'fecha_vencimiento', 'imagen'
    ];

    public function categoria()
{
    return $this->belongsTo(Categoria::class);
}
}
