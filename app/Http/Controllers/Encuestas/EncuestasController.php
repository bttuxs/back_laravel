<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Encuesta;
use App\Models\Respuestas;
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

  public function encuestasResuelta(){
    $encuestas = DB::select(DB::raw("select encuesta.*, solucion.*, concat_ws(' ', users.nombre, users.apellidoPaterno) as usuario , clientes.razonSocial as cliente from encuesta
                      inner join(SELECT distinct idEncuesta, uuid, idUser FROM respuestas) as solucion on solucion.idEncuesta = encuesta.idEncuestas
                      left join users on users.id = solucion.idUser
                      left join clientes on clientes.idCliente = encuesta.idCliente"));
    return response($encuestas);
  }

  public function respuestas(Request $request){

    $validatedData = $request->validate([
        'uuid' => 'required',
    ]);

    $respuestas = Respuestas::select('respuestas.*', 'encuesta.nombre','encuesta.descripcion','preguntas.pregunta', 'users.nombre as user', 'users.apellidoPaterno as ap', 'users.apellidoMaterno as am')
                      ->leftJoin('encuesta', 'encuesta.idEncuestas', '=', 'respuestas.idEncuesta')
                      ->leftJoin('preguntas', 'preguntas.idPregunta', '=', 'respuestas.idPregunta')
                      ->leftJoin('users','users.id', '=', 'respuestas.idUser')
                      ->where('uuid', $request->uuid)->get();
    $pathImage = app()->basePath()."/app/Images/".$request->uuid;
    $images = [];
    if(file_exists($pathImage)){
      $files = scandir($pathImage);
      foreach ($files as $key => $value) {
        if($value != "." && $value != ".."){
          $img = $pathImage."/".$value;
          $bin = file_get_contents($img);
          $images[] = "data:image/png;base64,".base64_encode($bin);
        }
      }
    }


    return response(["encuesta" => $respuestas, "images" => $images]);
  }
}
