<?php

namespace App\Http\Controllers;
use App\Models\Empleado; // <- Importa el modelo
use Inertia\Inertia;


use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Vista
    public function index()
    {
        return Inertia::render('Empleados/Index', [
            //'empleados' => Empleado::all(), //para enviar datos iniciales
        ]);
    }

    // API solo datos
    public function obtenerDatos()
    {
        //return response()->json(Empleado::all());
    }
}
