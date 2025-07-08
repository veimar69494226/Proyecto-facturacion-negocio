<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductoController 
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
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Guardar imagen en storage/app/public/productos
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $ruta = $imagen->store('productos', 'public'); // carpeta: storage/app/public/productos
            $url = Storage::url($ruta); // genera: /storage/productos/archivo.jpg
        } else {
            return response()->json(['error' => 'No se recibió ninguna imagen'], 400);
        }

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'imagen' => $url, // Guardamos la URL relativa
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

        // Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric',
            'descripcion' => 'nullable|string',
            'cantidad' => 'sometimes|required|integer',
            'imagen' => 'sometimes|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Si hay nueva imagen, eliminar la anterior y guardar la nueva
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior (opcional)
            if ($producto->imagen) {
                $rutaAnterior = str_replace('/storage/', '', $producto->imagen); // convertir URL a ruta relativa
                Storage::disk('public')->delete($rutaAnterior);
            }

            // Guardar nueva imagen
            $ruta = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = Storage::url($ruta); // /storage/productos/xyz.jpg
        }

        // Actualizar los demás campos
        $producto->fill($request->except('imagen')); // Evita sobreescribir imagen si no se envió
        $producto->save();

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

        // Eliminar imagen del storage si existe
        if ($producto->imagen) {
            // Convierte /storage/productos/xyz.jpg → productos/xyz.jpg
            $ruta = str_replace('/storage/', '', $producto->imagen);
            Storage::disk('public')->delete($ruta);
        }

        // Eliminar producto de la base de datos
        $producto->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente'], 200);
    }
}
