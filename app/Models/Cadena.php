<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadena extends Model
{
  protected $table = "cadena";
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCadena',
        'nombreCadena',
        'descripcionCadena',
    ];
}
