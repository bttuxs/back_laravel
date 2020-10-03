<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function(){
  Route::get('', function () {
     return response()->json([ 'error' => 500, 'message'=> 'Not found' ]);
  });
  Route::prefix('service')->group(function(){
    Route::prefix('usuarios')->group(function(){
      Route::post('/', 'Admin\UsuariosController@getUsers');
      Route::post('/crear', 'Admin\UsuariosController@create');
      Route::post('/desactivar', 'Admin\UsuariosController@desactivar');
      Route::post('/activar', 'Admin\UsuariosController@activar');
      Route::post('/reenviomail', 'Admin\UsuariosController@reenviomail');
    });
  });
});

Route::post('/login/auth', 'Api\AuthController@login');
//Route::post('/admin/add', 'Admin\UsuariosController@create');
Route::post('/otp/validar', 'Admin\OtpController@validateOtp');
Route::post('/otp/password', 'Admin\OtpController@guardarpassword');
