<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SucursalController 
{
    // Mostrar todas las sucursales
    public function index()
    {
        $sucursales = Sucursal::all(); // Obtener todas las sucursales

        return response()->json($sucursales, 200);
    }

    // Crear una nueva sucursal
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear la sucursal
        $sucursal = Sucursal::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        return response()->json([
            'message' => 'Sucursal creada exitosamente',
            'sucursal' => $sucursal
        ], 201);
    }

    // Obtener una sucursal por ID
    public function show($id)
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }

        return response()->json($sucursal, 200);
    }

    // Actualizar una sucursal
    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }

        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'direccion' => 'sometimes|required|string|max:255',
            'telefono' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar la sucursal
        $sucursal->update($request->all());

        return response()->json([
            'message' => 'Sucursal actualizada exitosamente',
            'sucursal' => $sucursal,
        ], 200);
    }

    // Eliminar una sucursal
    public function destroy($id)
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrada'], 404);
        }

        // Eliminar la sucursal
        $sucursal->delete();

        return response()->json(['message' => 'Sucursal eliminada exitosamente'], 200);
    }
}
