<?php

// 1. La raíz ahora carga tu login con el nombre correcto
Route::get('/', function () {
    return view('login_vista'); 
});

// 2. La ruta de las motos
Route::get('motos', 'MotoController@index');