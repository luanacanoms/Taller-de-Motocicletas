<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
       
        $total_ventas = DB::table('facturas')->sum('Total');

        
        $total_clientes = DB::table('clientes')->count();

        
        $total_motos = DB::table('motocicletas')->count();

        
        $recientes = DB::table('facturas')->orderBy('Fecha_Emision', 'desc')->limit(5)->get();

        
        $motos_list = DB::table('facturas')->select('Matricula')->distinct()->get();

        
        return view('dashboard_vista', compact('total_ventas', 'total_clientes', 'total_motos', 'recientes', 'motos_list'));
    }
}