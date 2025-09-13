<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public $timestamps = false;

    public $table='empleados';

    public $primaryKey = 'empleado_id';

    protected $fillable = [
        'nombre',
        'dui',
        'email',
        'telefono',
        'direccion',
        'cargo'
    ];

}
