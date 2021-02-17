<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precios extends Model
{
  protected $table = "precios";
  use HasFactory;
  protected $fillable = [
      'idSede',
      'idProducto',
      'precio'
  ];
}
