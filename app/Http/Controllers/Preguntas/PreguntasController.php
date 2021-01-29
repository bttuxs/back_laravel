<?php

namespace App\Http\Controllers\Preguntas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preguntas;
use App\Models\Respuestas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PreguntasController extends Controller
{
  public function crearPreguntas(Request $request){
    $validatedData = $request->validate([
      'idEncuesta' => 'required',
      'pregunta' => 'required'
    ]);
    $pregunta = Preguntas::create($validatedData);
    if($pregunta){
      return response($pregunta);
    }
    $response = ["status" => "false", "mensaje" => "No se pudo crear la pregunta"];
    return response($response, 404);
  }

  public function listarPreguntas(Request $request){
    $validatedData = $request->validate([
      'idEncuesta' => 'required',
    ]);
    $preguntas = Preguntas::where('idEncuesta', $request->idEncuesta)
                            ->where('active', 1)->get();
    return response($preguntas);
  }

  public function removerPreguntas(Request $request){
    $validatedData = $request->validate([
      'idPregunta' => 'required',
    ]);

    $preguntas = Preguntas::where('idPregunta', $request->idPregunta)->update(["active"=>0]);
    return response($preguntas);
  }

  public function guardarPreguntaRespuesta(Request $request){
    $userAuth = Auth::user();
    $idUser = $userAuth->id;
    $uuid = md5($userAuth->id.date('y-m-d G:i:s'));
    $data =[
      "idUser" => $idUser,
      "idEncuesta" => $request->idEncuesta
    ];
    DB::beginTransaction();
    try{
      foreach ($request->preguntas as $key => $value) {
        $data =[
          "idUser" => $idUser,
          "idEncuesta" => $request->idEncuesta,
          "idSede" => $request->idSede,
          "uuid" => $uuid,
          "idPregunta" => $key,
          "respuesta" => $value
        ];
        Respuestas::create($data);
      }
      DB::commit();
      $response = ["status" => "true", "mensaje" => "Guardado de encuesta correcta.", "uuid" => $uuid];
      return response($response);
    }catch(\Exception $e){
      DB::rollBack();
      $message = "";
      if(strpos($e->getMessage(), 'Duplicate entry')){
        $message = "Error al guardar la respuesta, es posible que exista, valida e intenta de nuevo";
      }else{
        $message = "Error al guardar la respuesta valide la informacion e intente de nuevo.";
      }
      $response = ["status" => "false", "mensaje" => $message];
      return response($response, 404);
    }

  }

}
