<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
  protected $table = "domicilio";
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idDomicilio',
        'exterior',
        'interior',
        'calle',
        'colonia',
        'cp',
        'alcaldia',
        'ciudad',
    ];
}
