<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
  protected $table = "otp";
    use HasFactory;

    protected $fillable = [
        'idOtp',
        'idUser',
        'idTipo',
        'otp',
        'created_at'
    ];
}
