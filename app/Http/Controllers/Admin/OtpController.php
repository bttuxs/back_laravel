<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;

class OtpController extends Controller
{
  public function validateOtp(Request $request)
  {
    $otp = Otp::where("otp", $request->otp)->first();
    $fechaOtp = $otp->created_at;
    $ahora = Carbon::now();
    $response = ["status" => "false", "mensaje" => "Error otp invalida o inactiva, valide e intente de nuevo"];
    if($fechaOtp->diffInHours($ahora) < 73){
      $response = ["status" => "true", "mensaje" => "otp valido"];
      return response($response);
    }
    return response($response, 404);
  }

  public function guardarpassword(Request $request)
  {
    try{
      $otp = Otp::where("otp", $request->otp)->first();
      $response = ["status" => "false", "mensaje" => "Error otp invalida o inactiva, valide e intente de nuevo"];
      if($otp){
        $fechaOtp = $otp->created_at;
        $ahora = Carbon::now();
        if($fechaOtp->diffInHours($ahora) < 73){
          $user = User::where("id", $otp->idUser)->update(["password" =>  bcrypt($request->password), "activo" => 1, "email_verified_at" => Carbon::now(), "activado" => 1 ]);
          if($user){
            Otp::where("otp", $request->otp)->delete();
            $response = ["status" => "true", "mensaje" => "contraseña actualizada"];
            return response($response);
          }
        }
      }
      return response($response, 404);
    }catch(Exception $e){
      return response($e, 404);
    }

  }

}
