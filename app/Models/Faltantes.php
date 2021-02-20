<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faltantes extends Model
{
    protected $table = "faltantes";
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idSede',
        'idProducto',
        'images',
        'situacion',
        'piezas'
    ];
}
