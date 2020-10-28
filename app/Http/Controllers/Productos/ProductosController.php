<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
  public function listarProductos(){
    $productos = Productos::where("productoPadre", 0)->get();
    return response($productos);
  }

  public function listarSubProductos(Request $request){
    $validatedData = $request->validate([
        'idProducto' => 'required',
    ]);
    $productos = Productos::where("productoPadre", $request->idProducto)->get();
    return response($productos);
  }

  public function todosProductos(){
    $productos = Productos::get();
    return response($productos);
  }

  public function crearProducto(Request $request){
    $validatedData = $request->validate([
        'nombre' => 'required',
        "descripcion" => 'required',
        'productoPadre' => '',
        "presentacion" => 'required',
        "contenido" => 'required',
        "upc" => 'required',
    ]);

    if($validatedData['productoPadre'] == Null){
      $validatedData['productoPadre'] = 0;
    }

    $productos = Productos::create($validatedData);

    if($productos){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta"];
      return response($response);
    }

    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

}
