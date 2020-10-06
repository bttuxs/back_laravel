<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Otp;
use App\Libs\RandomString;

class UsuariosController extends Controller
{
  public function create(Request $request){
    $validatedData = $request->validate([
        'nombre' => 'required',
        'email' => 'required',
        'tipoUser' => 'required'
    ]);

    $userData = $validatedData;
    $userData["plataforma"]= $request->tipoUser;
    if($request->apellidoPaterno){
      $userData["apellidoPaterno"] = $request->apellidoPaterno;
    }
    if($request->apellidoMaterno){
      $userData["apellidoMaterno"] = $request->apellidoMaterno;
    }
    $user = User::create($userData)->id;
    if($user){
      $String = new RandomString();
      $stringOtp = [
        "idUser" => $user,
        "otp" => $String->generateRandomString(30)
      ];
      $otp = Otp::create($stringOtp);
      $objData = (object) $userData;
      $objData->otp = $stringOtp["otp"];
      Mail::to($userData["email"])->send(new Mailer($objData));
    }

    return response($request);
  }

  public function getUsers(Request $request){
//      $users = User::leftjoin('clientes', 'clientes.idCliente', '=', 'users.idCliente')->where('plataforma',$request->idUser)->get();
      $users = User::where('plataforma',$request->idUser)->get();
      return response($users);
  }

  public function desactivar(Request $request){
    $users = User::where('id',$request->userId)->update(["activo"=> 0]);
    $response = ["status" => "false", "mensaje" => "Error otp invalida o inactiva, valide e intente de nuevo"];
    if($users){
      $response = ["status" => "true", "mensaje" => "desactivacion correcta"];
      return response($response);
    }
    return response($response, 404);
  }

  public function activar(Request $request){
    $users = User::where('id',$request->userId)->update(["activo"=> 1]);
    $response = ["status" => "false", "mensaje" => "Error otp invalida o inactiva, valide e intente de nuevo"];
    if($users){
      $response = ["status" => "true", "mensaje" => "Activacion correcta"];
      return response($response);
    }
    return response($response, 404);
  }

  public function reenviomail(Request $request){
    Otp::where("idUser", $request->userId)->delete();
    $users = User::where('id',$request->userId)->first();

    $String = new RandomString();
    $stringOtp = [
      "idUser" => $users->id,
      "otp" => $String->generateRandomString(30)
    ];
    $otp = Otp::create($stringOtp);
    $users->otp = $stringOtp["otp"];
    Mail::to($users->email)->send(new Mailer($users));
    return response($users);
  }

  public function createUser(Request $request){
    $validatedData = $request->validate([
        'idEmpleado' => 'required'
    ]);
    $pass = new Password();
    $newPass = $pass->generateRandomString();
    $validatedData['hash'] = $pass->getHash();
    $validatedData['password'] = $newPass;
    $validatedData['status'] = 1;
    $validatedData['creador'] = 1;
    $password = $pass->makePass($validatedData['hash'], $validatedData['idEmpleado'], $validatedData['password'], $validatedData['idEmpleado']);
    $validatedData['password'] = bcrypt($password);
    $user = User::create($validatedData);
    $accessToken = $user->createToken('authToken')->accessToken;
    return response([ 'user' => $user, 'access_token' => $accessToken, "pass" => $newPass]);
  }
}
