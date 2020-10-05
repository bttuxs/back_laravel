<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clientes;

class ClientesController extends Controller
{
  public function crearClientes(Request $request){
    $data_validacion = $request->validate([
      'razonSocial' => 'required',
      'descripcion' => 'required',
      'rfc' => ''
    ]);
    $cliente = Clientes::create($data_validacion);
    if($cliente){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta"];
      return response($response);
    }

    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

  public function clientesGeneral(){
    $clientes = Clientes::get();
    return response($clientes);
  }

  public function activar(Request $request){
    $data_validacion = $request->validate([
      'idCliente' => 'required'
    ]);

    $cliente = Clientes::where('idCliente', $request->idCliente)->update(['activo' => '1']);
    if($cliente){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta"];
      return response($response);
    }

    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

  public function inactivar(Request $request){
    $data_validacion = $request->validate([
      'idCliente' => 'required'
    ]);

    $cliente = Clientes::where('idCliente', $request->idCliente)->update(['activo' => '0']);
    if($cliente){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta"];
      return response($response);
    }
    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

}
