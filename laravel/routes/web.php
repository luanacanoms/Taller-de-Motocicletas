<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TallerController;


Route::get('/', function () {
    return view('login_vista');
});


Route::post('validar', function (Request $request) {
    if ($request->usuario === 'admin' && $request->password === '1234') {
        
        
        if (session_status() === PHP_SESSION_NONE) { 
            session_start(); 
        }
        $_SESSION['autenticado'] = "SI";
        $_SESSION['usuario'] = "admin";

       
        return redirect('menu.php'); 
    } else {
        return redirect('/')->with('error', 'Credenciales incorrectas');
    }
});


Route::get('menu', [DashboardController::class, 'index']);
Route::get('motos', [MotoController::class, 'index']);
Route::get('datos_motocicleta/{matricula}', [TallerController::class, 'mostrarMoto']);
Route::get('actualizar_cliente/{dni}/{telefono}', [TallerController::class, 'actualizarTelefono']);
Route::get('introducir_motocicleta', [TallerController::class, 'formularioMoto']);
Route::post('guardar_motocicleta', [TallerController::class, 'guardarMoto']);