<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotoController extends Controller
{
    public function index()
    {
        $motos = DB::select('SELECT * FROM motocicletas ORDER BY Matricula ASC');

        return view('motos_vista', ['motos' => $motos]);
    }
}