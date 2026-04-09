<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Motocicleta extends Model {
    protected $table = 'motocicletas'; 
    protected $primaryKey = 'matricula'; 
    public $incrementing = false;
    protected $fillable = ['matricula', 'marca', 'modelo', 'anyo', 'color', 'id_cliente'];
    public $timestamps = false; // Añade esto para evitar errores si no usas timestamps
}
?>