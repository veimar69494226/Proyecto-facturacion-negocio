<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {
        return response()->json(Vendedor::all(), 200);  // Devuelve todos los vendedores
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',  // Valida el nombre
        ]);

        $vendedor = Vendedor::create($request->all());  // Crea un nuevo vendedor

        return response()->json([

           
         'message' => 'Vendedor creado exitosamente',
            'data' => $vendedor
           
        ]
            
            , 201);  // Devuelve el vendedor creado
    }

    public function show($id)
    {
        $vendedor = Vendedor::find($id);  // Busca un vendedor por ID

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor no encontrado'], 404);
        }

        return response()->json($vendedor, 200);  // Devuelve el vendedor
    }

    public function update(Request $request, $id)
    {
        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor no encontrado'], 404);
        }

        $vendedor->update($request->all());  // Actualiza el vendedor

        return response()->json($vendedor, 200);  // Devuelve el vendedor actualizado
    }

    public function destroy($id)
    {
        $vendedor = Vendedor::find($id);

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor no encontrado'], 404);
        }

        $vendedor->delete();  // Elimina el vendedor

        return response()->json(['message' => 'Vendedor eliminado correctamente'], 200);
    }
}
