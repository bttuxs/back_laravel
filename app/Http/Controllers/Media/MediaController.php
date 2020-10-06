<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
  public function cargaEvidencia(Request $request){
    $pathImage = app()->basePath()."/app/Images/".$request->uuid;
    $data = [];
    $images = $request->files;
    foreach ($images as $image) {
      foreach ($image as $item) {
        $name = $item->getClientOriginalName();
        if($item->isValid()){
          $item->move($pathImage, $item->getClientOriginalName());
        }
      }
    }
    return response()->json(["status"=>"ok"]);
  }
}
