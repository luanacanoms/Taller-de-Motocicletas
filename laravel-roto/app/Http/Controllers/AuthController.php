<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Recibimos los datos (estilo Laravel)
        $usuario = $request->input('usuario');
        $password = $request->input('password');

        // 2. Tu regla estricta del profesor
        if ($usuario === 'admin' && $password === '1234') {
            
            // Laravel maneja las sesiones así:
            session(['autenticado' => 'SI', 'usuario' => $usuario]);

            // Redirigimos a la ruta de las motos
            return redirect('motos');
            
        } else {
            // Si falla, volvemos atrás con un error
            return redirect('/')->with('error', 'Usuario o contraseña incorrectos');
        }
    }
}