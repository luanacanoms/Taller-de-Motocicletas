<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motocicleta extends Model
{
    protected $table = 'Motocicletas';
    protected $primaryKey = 'Matricula'; 
    public $incrementing = false; // Porque la matrícula es texto, no un número autoincremental
}