<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
        'user' => 'required|string|email',
        'pass' => 'required|string'
    ]);

    $credentials = array("password" => $request->pass, "email" => $request->user, "activo" => "1");
    $user = User::where("email", $request->user)->where("activo", 1)->first();

    if (!Auth::attempt($credentials)) {
      return response(array("status" => "error",
                   "message" => "Credenciales Invalidas, verifique e intente de nuevo"), 401);
    }

    $accessToken = auth()->user()->createToken('authToken')->accessToken;
    $letters = strtoupper(substr($user->nombre, 0,1).substr($user->apellidoPaterno, 0,1));
    $params = array("status" => "true",
          "message" => "Usuario Valido",
          "user" => array("nombre" => $user->nombre,
                          "apellidoPaterno" => $user->apellidoPaterno,
                          "apellidoMaterno" => $user->apellidoMaterno,
                          "letras" => $letters),
          "access_token" => $accessToken);
    return response($params);

    return response()
          ->json();
  }
  /*
  public function login(Request $request)
  {
     $user = User::leftjoin("incidencias_cls.alfa","alfa.Id_Empleado", "=", "users.idEmpleado")
                    ->where("users.idEmpleado", $request->username)->where("status","1")
                    ->first();
     if($user != null)
     {
       $pass = new Password();
       $pass = $pass->makePass($user->hash, $user->idEmpleado,$request->pass, $user->idEmpleado);
       $credentials = array("idEmpleado" => $request->username, "password" => $pass, "status" => "1");

       if (!auth()->attempt($credentials)) {
           return response(['message' => 'Invalid Credentials']);
       }
       $user->ultimoAcceso = date('Y-m-d H:i:s');
       $user->save();
       $accessToken = auth()->user()->createToken('authToken')->accessToken;
       $params = array("status" => "ok",
             "message" => "Usuario Valido",
             "user" => array("idEmpleado" => $user->idEmpleado,
                             "statusPass" => $user->changePassword,
                             "user" => $user->admin,
                             "nombre" => $user->Nombre_completo),
             "postalId" => ENV('APP_PORTALID'),
             "access_token" => $accessToken);
       return response($params);
     } else {
       return response()
             ->json(array("status" => "error",
                          "message" => "Credenciales Invalidas, verifique e intente de nuevo"
                          ));
      }
   }
   */

}
