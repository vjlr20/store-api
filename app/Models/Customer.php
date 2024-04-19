<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    // 1. Vincular la tabla al modelo
    protected $table = "customers";

    // 2. Definición de campos a modificar o insertar
    protected $fillable = array(
        'names',
        'lastnames',
        'born_date',
        'dui',
        'address',
        'customer_uid'
    );

    // 3. Definición de campos a ocultar (A nivel de consulta)
    protected $hidden = array(
        'address',
    );
}
