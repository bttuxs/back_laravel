<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = "encuesta";
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idEncuesta',
        'nombre',
        'descripcion',
        'idProducto',
        'idSubProducto',
        'idSede',
        'idCliente'
    ];
}
