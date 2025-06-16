<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function create()
    {
        return Inertia::render('Productos/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'presentacion' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'existencia_inicial' => 'required|integer',
            'fecha_vencimiento' => 'nullable|date',
            'imagen' => 'nullable|image|max:5120', // 5MB
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $path;
        }

        Producto::create($validated);

        return back();

    }

   public function index()
    {
        $productos = \App\Models\Producto::latest()->get();
        return response()->json($productos);
    }

   public function destroy($id)
{
    Producto::findOrFail($id)->delete();

    return redirect()->back(); // ✅ Esto sí lo espera Inertia
}




}