<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController 
{
    // Método para crear un nuevo cliente
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear el cliente
        $cliente = Cliente::create([
            'nombre' => $request->nombre,
        ]);

        // Retornar la respuesta con el cliente creado
        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'cliente' => $cliente,
        ], 201);
    }

    // Método para obtener todos los clientes
    public function index()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes

        return response()->json([
            'clientes' => $clientes,
        ], 200);
    }

    // Método para obtener un cliente por su ID
    public function show($id)
    {
        $cliente = Cliente::find($id); // Buscar el cliente por ID

        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado',
            ], 404);
        }

        return response()->json([
            'cliente' => $cliente,
        ], 200);
    }

    // Método para actualizar un cliente
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $cliente = Cliente::find($id); // Buscar el cliente por ID

        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado',
            ], 404);
        }

        // Actualizar los datos del cliente
        $cliente->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'cliente' => $cliente,
        ], 200);
    }

    // Método para eliminar un cliente
    public function destroy($id)
    {
        $cliente = Cliente::find($id); // Buscar el cliente por ID

        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado',
            ], 404);
        }

        // Eliminar el cliente
        $cliente->delete();

        return response()->json([
            'message' => 'Cliente eliminado exitosamente',
        ], 200);
    }
}
