<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('motos', 'MotoController@index');

Route::get('datos_motocicleta/{matricula}', 'MotoController@mostrar');


Route::get('actualizar_cliente/{dni}/{telefono}', 'MotoController@actualizarTelefono');

Route::get('introducir_cliente', 'MotoController@formulario');

Route::post('guardar_cliente', 'MotoController@guardar');