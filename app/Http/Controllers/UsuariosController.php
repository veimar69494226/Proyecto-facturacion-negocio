<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,vendedor',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $usuario = Usuarios::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'usuario' => $usuario
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Algo salió mal: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para iniciar sesión con correo y contraseña
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = Usuarios::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        Auth::login($usuario);

        return response()->json([
            'message' => 'Login exitoso',
            'usuario' => $usuario
        ], 200);
    }

    // Obtener todos los usuarios
    public function getAllUsers()
    {
        $usuarios = Usuarios::all();

        return response()->json([
            'usuarios' => $usuarios
        ], 200);
    }

    // Obtener un usuario por ID
    public function getUserById($id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'usuario' => $usuario
        ], 200);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|in:admin,vendedor',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['nombre', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'usuario' => $usuario
        ], 200);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = Usuarios::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ], 200);
    }
}