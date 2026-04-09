<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motocicleta;
use App\Models\Cliente; // Certifique-se de ter o modelo Cliente criado

class MotoController extends Controller
{
    // MISSÃO 1: Mostrar dados por MATRÍCULA
    public function mostrar($matricula)
    {
        $moto = Motocicleta::find($matricula);

        if (!$moto) {
            return "No se encontró ninguna motocicleta con la matrícula: " . $matricula;
        }

        return view('moto_detalle', compact('moto'));
    }

    // MISSÃO 2: Atualizar telefone por DNI
    // URL: /actualizar_cliente/{dni}/{telefono}
    public function actualizarTelefono($dni, $telefono)
    {
        // Usamos o Eloquent para buscar o cliente pelo DNI
        $cliente = Cliente::where('dni', $dni)->first();

        if ($cliente) {
            $cliente->telefono = $telefono;
            $cliente->save(); // O ORM Eloquent faz o UPDATE no banco automaticamente
            return "El teléfono del cliente com DNI $dni foi atualizado para $telefono.";
        }

        return "Cliente no encontrado.";
    }

    // MISSÃO 3: Mostrar o formulário
    public function formulario()
    {
        return view('form_cliente');
    }

    // MISSÃO 3: Salvar os dados do formulário (POST)
    public function guardar(Request $request)
    {
        // O create() usa o array $fillable que definimos no Modelo
        Motocicleta::create($request->all());

        return "Datos de la motocicleta guardados con éxito.";
    }
}

use App\Http\Controllers\MotoController;
use Illuminate\Support\Facades\Route;

// Missão 1: Buscar dados da moto
Route::get('/datos_motocicleta/{matricula}', [MotoController::class, 'mostrar']);

// Missão 2: Atualizar telefone do cliente
Route::get('/actualizar_cliente/{dni}/{telefono}', [MotoController::class, 'actualizarTelefono']);

// Missão 3: Formulário de inserção (GET mostra, POST salva)
Route::get('/introducir_cliente', [MotoController::class, 'formulario']);
Route::post('/guardar_cliente', [MotoController::class, 'guardar']);