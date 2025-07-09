<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendedorController 
{
    // Mostrar todos los vendedores
    public function index()
    {
        $vendedores = Vendedor::with('usuario')->get(); // Obtener todos los vendedores con la relación de usuario

        return response()->json($vendedores, 200);
    }

    // Crear un nuevo vendedor
    public function store(Request $request)
{
    $request->validate([
        'idUsuarios' => 'required|exists:usuarios,id', // Verifica que el idUsuarios exista en la tabla usuarios
        'telefono' => 'nullable|string|max:255', // Si el teléfono es opcional
    ]);

    $vendedor = Vendedor::create([
        'idUsuarios' => $request->idUsuarios,
        'telefono' => $request->telefono,
    ]);

    return response()->json([
        'message' => 'Vendedor creado exitosamente',
        'vendedor' => $vendedor
    ], 201);
}

    // Obtener un solo vendedor por ID
    public function show($id)
    {
        $vendedor = Vendedor::with('usuario')->find($id);

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor no encontrado'], 404);
        }

        return response()->json($vendedor, 200);
    }

    // Actualizar un vendedor
    public function update(Request $request, $id)
    {
        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor no encontrado'], 404);
        }

        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'idUsuarios' => 'sometimes|required|exists:usuarios,id',
            'telefono' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar el vendedor
        $vendedor->update($request->all());

        return response()->json([
            'message' => 'Vendedor actualizado exitosamente',
            'vendedor' => $vendedor,
        ], 200);
    }

    // Eliminar un vendedor
    public function destroy($id)
    {
        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            return response()->json(['message' => 'Vendedor no encontrado'], 404);
        }

        // Eliminar el vendedor
        $vendedor->delete();

        return response()->json(['message' => 'Vendedor eliminado exitosamente'], 200);
    }
}
