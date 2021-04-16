<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeoPrecios extends Model
{
    protected $table = "chequeoPrecio";
    use HasFactory;
    protected $fillable = [
        'idPrecio',
        'idTienda',
        'precioPromocion',
        'fechaInicioPromocion',
        'images',
        'fechaTerminoPromocion',
        'idUsuario',
        'observaciones',
    ];
}
