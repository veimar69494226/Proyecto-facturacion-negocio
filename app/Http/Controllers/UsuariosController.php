<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsuariosController 
{
    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        try {
            // Validación de los datos de entrada
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:admin,vendedor', // Aseguramos que role solo pueda ser 'admin' o 'vendedor'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Crear el usuario
            $usuario = Usuarios::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hashear la contraseña
                'role' => $request->role, // Asignar el rol
            ]);

            // Retornar la respuesta con el usuario registrado
            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'usuario' => $usuario
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Algo salió mal: ' . $e->getMessage()], 500);
        }
    }

    // Método para iniciar sesión con correo y contraseña
    public function login(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Si hay errores de validación, retornar una respuesta con los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buscar al usuario por email
        $usuario = Usuarios::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // Si la autenticación es exitosa, iniciar sesión
        Auth::login($usuario);

        // Retornar respuesta con el usuario autenticado
        return response()->json([
            'message' => 'Login exitoso',
            'usuario' => $usuario
        ], 200);
    }

    // Obtener todos los usuarios (ahora sin autenticación de token)
    public function getAllUsers(Request $request)
    {
        // Obtener todos los usuarios sin filtro de autenticación
        $usuarios = Usuarios::all(); // Obtiene todos los usuarios

        return response()->json([
            'usuarios' => $usuarios
        ], 200);
    }

    // Obtener un usuario por ID
    public function getUserById($id)
    {
        $usuario = Usuarios::find($id); // Buscar el usuario por id

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'usuario' => $usuario
        ], 200);
    }
}
