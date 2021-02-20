<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChequeoPrecios;
use App\Models\Precios;

class PrecioController extends Controller
{
    public function listarChequeos(){
      $precios = ChequeoPrecios::select('productos.*', 'sedes.*', 'cadena.*', 'precios.precio', 'chequeoPrecio.*', 'productos.nombre as nombreProducto', 'sedes.nombre as nombreSede', 'categoria.nombre as categoria')
                                ->leftJoin('precios','precios.idPrecio', '=', 'chequeoPrecio.idPrecio')
                                ->leftJoin('productos', 'productos.idProducto', '=', 'precios.idProducto')
                                ->leftJoin('productos as categoria', 'categoria.idProducto', '=', 'productos.productoPadre')
                                ->leftJoin('sedes', 'sedes.idSede', '=', 'precios.idSede')
                                ->leftJoin("cadena", "cadena.idCadena", "=", "sedes.idCadena")->get();
      return response($precios);
    }

    public function precioProducto(Request $request){
      $validatedData = $request->validate([
          'idSede' => 'required'
      ]);
      $precio = Precios::join("productos", "productos.idProducto", "=", "precios.idProducto")->where("idSede", $request->idSede)->get();
      return response($precio);
    }

    public function guardarChequeo(Request $request){
      $uuid = md5("chequeo".date("G:i:s"));
      $fechaInicio = date('Y-m-d', strtotime($request->fechaInicioPromocion));
      $fechaTermino =date('Y-m-d', strtotime( $request->fechaTerminoPromocion));
      $data = ["idPrecio" => $request->idProducto['idPrecio'],
              "precioPromocion" => $request->precioPromocion,
              "fechaInicioPromocion" => $fechaInicio,
              "fechaTerminoPromocion" =>$fechaTermino,
              "images" => $uuid,
              "idUsuario" => 13,
              "observaciones" => $request->observaciones];
      $chequeoPrecio = ChequeoPrecios::create($data);
      $result = [
        "data" => $data,
        "insert" => $chequeoPrecio,
        "uuid" => $uuid
      ];
      return response($result);
    }
}
