<?php

namespace App\Http\Controllers\Sedes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sedes;
use App\Models\Domicilio;
class SedesController extends Controller
{
  public function generalSedes(Request $request){
    $sedes = Sedes::get();
    return response($sedes);
  }

  public function crearSede(Request $request){
    DB::beginTransaction();
    try{
      $domicilioData = (array)$request->domicilio;
      $idDomicilio = Domicilio::create($domicilioData)->id;
      $sedeData = [
        "nombre" => $request->sede["nombre"],
        "idDomicilio" => $idDomicilio
      ];
      $sede = Sedes::create($sedeData);
      DB::commit();
      $response = ["status" => "true", "mensaje" => "Creacion de sede correcta."];
      return response($response);
    } catch(\Exception $e){
      DB::rollBack();
      $message = "";
      if(strpos($e->getMessage(), 'Duplicate entry')){
        $message = "Error al crear la sede, es posible que exista, valida e intenta de nuevo";
      }else{
        $message = "Error al crear sede valide la informacion e intente de nuevo.";
      }
      $response = ["status" => "false", "mensaje" => $message];
      return response($response, 404);
    }

  }
}
