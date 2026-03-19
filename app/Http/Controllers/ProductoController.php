<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller 
{
    // Mostrar todos los productos
    public function index()
    {
        $productos = Producto::all(); // Obtener todos los productos

        return response()->json($productos, 200);
    }

    // Crear un nuevo producto
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer',
            'imagen' => 'required|string|max:455',  // Suponiendo que se pasa una URL o ruta de imagen
            'categoria' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'imagen' => $request->imagen,
            'categoria' => $request->categoria,
        ]);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => $producto
        ], 201);
    }

    // Obtener un producto por ID
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    // Actualizar un producto
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric',
            'descripcion' => 'nullable|string',
            'cantidad' => 'sometimes|required|integer',
            'imagen' => 'sometimes|required|string|max:255',
            'categoria' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar el producto
        $producto->update($request->all());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $producto,
        ], 200);
    }

    // Eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Eliminar el producto
        $producto->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
    }
}
