<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Faltantes;

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

  public function listarSubProductosGeneral(Request $request){
    $productos = Productos::where("productoPadre", '>', '0')->get();
    return response($productos);
  }

  public function todosProductos(){
    $productos = Productos::get();
    return response($productos);
  }

  public function crearProducto(Request $request){
    $validatedData = $request->validate([
        'nombre' => 'required',
        "descripcionProducto" => 'required',
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

  public function faltantes(Request $request){
    $validatedData = $request->validate([
        'idSede' => 'required',
        "idProducto" => 'required',
        "situacion" => 'required'
    ]);
    $uuid = md5('faltantes'.date('Y-m-d G:i:s'));
    $validatedData["images"] = $uuid;
    $validatedData["idSede"] = $validatedData["idSede"]["idSede"];

    $faltantes = Faltantes::create($validatedData);
    if($faltantes){
      $response = ["status" => "true", "mensaje" => "creacion de producto correcta", "uuid" => $uuid];
      return response($response);
    }

    $response = ["status" => "false", "mensaje" => "Error al crear producto valide e intente de nuevo."];
    return response($response, 404);
  }

  public function listaFaltantes(){
    $productos = Faltantes::select('productos.*', 'productos.nombre as nombreProducto', 'categoria.nombre as categoria','sedes.*', 'sedes.nombre as nombreSede', 'cadena.*', 'faltantes.*')
                ->leftJoin('sedes', 'sedes.idSede','=', 'faltantes.idSede')
                ->leftJoin('cadena', 'cadena.idCadena','=', 'sedes.idCadena')
                ->leftJoin('productos', 'productos.idProducto', '=', 'faltantes.idProducto')
                ->leftJoin('productos  as categoria', 'categoria.idProducto', '=', 'productos.productoPadre')
                ->get();
    return response($productos);

  }

}
