<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotoController extends Controller
{
    public function index()
    {
        // Consulta limpia a la tabla (en minúsculas)
        $motos = DB::select('SELECT * FROM motocicletas ORDER BY Matricula ASC');

        // Enviamos a la vista que ya tiene el nombre correcto
        return view('motos_vista', ['motos' => $motos]);
    }
}