<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Encuesta;

class EncuestasController extends Controller
{
  public function crearEncuesta(Request $request){
    $validatedData = $request->validate([
        'nombre' => 'required',
        'descripcion' => '',
        'idProducto' => 'required',
        'idSubProducto' => 'required',
        'idSede' => '',
        'idCliente' => ''
    ]);
    $encuestas = Encuesta::create($validatedData);
    return response($encuestas);
  }

  public function listarEncuestas(){
    $encuestas = Encuesta::select('encuesta.*', 'categoria.nombre as categoria', 'subcategoria.nombre as subcategoria', 'clientes.*', 'sedes.nombre as sede')
                          ->join('productos as categoria','categoria.idProducto', '=','encuesta.idProducto' )
                          ->join('productos as subcategoria','subcategoria.idProducto', '=','encuesta.idSubProducto' )
                          ->leftJoin('clientes','clientes.idCliente', '=','encuesta.idCliente' )
                          ->leftJoin('sedes','sedes.idSede', '=','encuesta.idSede' )
                          ->get();
    return response($encuestas);
  }

  public function validarIdEncuesta(Request $request){
    $encuesta = Encuesta::where('idEncuestas',$request->idEncuesta)->get();
    if(count($encuesta)){
      $response = ["status" => "true", "mensaje" => "Existe la encuesta"];
      return response($response);
    }
    $response = ["status" => "false", "mensaje" => "No existe la encuesta"];
    return response($response, 404);
  }
}
