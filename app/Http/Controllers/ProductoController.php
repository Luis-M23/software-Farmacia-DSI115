<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Categoria;
use Carbon\Carbon;


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
            'presentacion' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'existencia_inicial' => 'required|integer',
            'fecha_vencimiento' => 'nullable|date',
            'imagen' => 'nullable|image|max:5120', // 5MB
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $path;
        }

        Producto::create($validated);

        return response()->json([
    'success' => true,
    'producto' => Producto::with('categoria')->latest()->first()
]);

    }

   public function index()
    {
        $productos = Producto::with('categoria')->latest()->get();
        $categorias = Categoria::all();

        // 🔶 Lógica para calcular productos por vencer (30 días)
        $hoy = Carbon::now();
        $porVencer = $productos->filter(function ($producto) use ($hoy) {
            return $producto->fecha_vencimiento &&
                   Carbon::parse($producto->fecha_vencimiento)->isBetween($hoy, $hoy->copy()->addDays(30));
        })->count();

        return Inertia::render('Products/Index', [
            'productos'   => $productos,
            'categorias'  => $categorias,
            'por_vencer'  => $porVencer, // ✅ Nueva prop para el frontend
        ]);
    }

    public function obtenerDatos()
{
    $productos = Producto::with('categoria')->latest()->get();
    return response()->json($productos);
}


   public function destroy($id)
{
    Producto::findOrFail($id)->delete();

    return redirect()->back();
}

public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'presentacion' => 'required|string|max:255',
        'proveedor' => 'required|string|max:255',
        'precio_compra' => 'required|numeric',
        'precio_venta' => 'required|numeric',
        'existencia_inicial' => 'required|integer',
        'fecha_vencimiento' => 'nullable|date',
        'imagen' => 'nullable|image|max:5120',
        'categoria_id' => 'required|exists:categorias,id',
    ]);

    if ($request->hasFile('imagen')) {
        // Opcional: eliminar imagen anterior si existe
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $path = $request->file('imagen')->store('productos', 'public');
        $validated['imagen'] = $path;
    }

    $producto->update($validated);

    return response()->json([
        'success' => true,
        'producto' => $producto->fresh()->load('categoria'),
    ]);
}

}
