<?php

namespace App\Http\Controllers\Sedes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sedes;
use App\Models\Domicilio;
use App\Models\Cadena;
class SedesController extends Controller
{
  public function generalSedes(Request $request){
    $sedes = Sedes::join("cadena", "cadena.idCadena","=", "sedes.idCadena")->get();
    return response($sedes);
  }

  public function cadenas(Request $request){
    $sedes = Cadena::get();
    return response($sedes);
  }


  public function crearSede(Request $request){
    $validatedData = $request->validate([
        'nombre' => 'required',
        "tiendaNo" => 'required',
        'idDomicilio' => '',
        "idCadena" => 'required',
        "tipoSede" => 'required',
        "ciudad" => 'required',
        "estado" => 'required',
    ]);

    $sede = Sedes::create($validatedData);
    if($sede){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta"];
      return response($response);
    }

    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

  public function filtrarSedes(Request $request){
    $validatedData = $request->validate([
      'filtroSede' => 'required'
    ]);
    $sedes = Sedes::join("cadena", "cadena.idCadena","=", "sedes.idCadena");
    $data  = $request->filtroSede;
    $data = explode(" ", $data);
    foreach ($data as $string) {
      $sedes->where('nombreCadena', 'like',"%{$string}%");
      $sedes->orWhere('nombre', 'like',"%{$string}%");
      if(is_numeric($string)){
        $sedes->orWhere('tiendaNo', "=", $string);
      }
    }
    $sedes = $sedes->get();

    return response($sedes);
  }
}
