<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motocicleta; // Modelos de Eloquent
use App\Models\Cliente;

class TallerController extends Controller
{

    public function mostrarMoto($matricula)
    {
        
        $moto = Motocicleta::where('Matricula', $matricula)->first();

        if (!$moto) {
            return "Motocicleta no encontrada.";
        }

        
        return view('datos_moto', compact('moto'));
    }

    
    public function actualizarTelefono($dni, $telefono)
    {
        
        $cliente = Cliente::where('DNI', $dni)->first();

        if ($cliente) {
            $cliente->Telefono = $telefono;
            $cliente->save(); // Guarda en la base de datos
            return "¡Éxito! El teléfono del cliente con DNI $dni se ha actualizado a $telefono.";
        } else {
            return "Error: Cliente con DNI $dni no encontrado.";
        }
    }

    
    public function formularioMoto()
    {
        return view('introducir_moto');
    }

    
    public function guardarMoto(Request $request)
    {
        
        $nuevaMoto = new Motocicleta();
        $nuevaMoto->Matricula = $request->matricula;
        $nuevaMoto->Marca = $request->marca;
        $nuevaMoto->Modelo = $request->modelo;
        $nuevaMoto->Anyo = $request->anyo;
        $nuevaMoto->Color = $request->color;
        $nuevaMoto->Id_Cliente = $request->id_cliente;
        
        $nuevaMoto->save();

        return redirect('introducir_motocicleta')->with('exito', '¡Motocicleta guardada correctamente en la base de datos!');
    }
}