<?php

namespace App\Http\Controllers\Preguntas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Preguntas;

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
}
