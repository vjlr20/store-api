<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Tabla que va interpretar
    private $table = "categorias";

    // Campos requeridos
    public $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Campos ocultos
    private $hidden = [
        'id'
    ];
}
