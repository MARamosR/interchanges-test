<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function Login( Request $request )
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Revisamos si el correo esta registrado.
        $user = User::where('email', $validated['email'])->first();
        
        if (!$user) {
            return response()->json([
                'message' => 'No existe un usuario para este correo electronico'
            ], 400);    
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Contraseña incorrecta'
            ], 400);
        }

        //Generar token de acceso.
        $token = $user->createToken('devifegrac')->plainTextToken;
       
        return response()->json([
            'user' => $user->name,
            'email' => $user->email,
            'token' => $token 
        ]);
    }

    public function logout(Request $request) 
    {
        
    }
}
