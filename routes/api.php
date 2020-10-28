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
    Route::prefix('productos')->group(function(){
      Route::get('/', 'Productos\ProductosController@listarProductos');
      Route::post('subproductos', 'Productos\ProductosController@listarSubProductos');
      Route::post('crear', 'Productos\ProductosController@crearProducto');
      Route::get('todos', 'Productos\ProductosController@todosProductos');
    });
    Route::prefix('clientes')->group(function(){
      Route::get('/', 'Clientes\ClientesController@clientesGeneral');
      Route::post('crear', 'Clientes\ClientesController@crearClientes');
      Route::post('activar', 'Clientes\ClientesController@activar');
      Route::post('inactivar', 'Clientes\ClientesController@inactivar');
    });
    Route::prefix('usuarios')->group(function(){
      Route::post('/', 'Admin\UsuariosController@getUsers');
      Route::post('/crear', 'Admin\UsuariosController@create');
      Route::post('/desactivar', 'Admin\UsuariosController@desactivar');
      Route::post('/activar', 'Admin\UsuariosController@activar');
      Route::post('/reenviomail', 'Admin\UsuariosController@reenviomail');
    });
    Route::prefix('sedes')->group(function(){
      Route::get('/', 'Sedes\SedesController@generalSedes');
      Route::post('/crear', 'Sedes\SedesController@crearSede');
    });
    Route::prefix('encuestas')->group(function(){
      Route::get('/', 'Encuestas\EncuestasController@listarEncuestas');
      Route::post('crear', 'Encuestas\EncuestasController@crearEncuesta');
      Route::post('existe', 'Encuestas\EncuestasController@validarIdEncuesta');
      Route::get('resuelta', 'Encuestas\EncuestasController@encuestasResuelta');
      Route::post('respuestas', 'Encuestas\EncuestasController@respuestas');
    });
    Route::prefix('preguntas')->group(function(){
      Route::post('crear', 'Preguntas\PreguntasController@crearPreguntas');
      Route::post('listar', 'Preguntas\PreguntasController@listarPreguntas');
      Route::post('remover', 'Preguntas\PreguntasController@removerPreguntas');
      Route::post('responder', 'Preguntas\PreguntasController@guardarPreguntaRespuesta');
    });
    Route::prefix('media')->group(function(){
      Route::post('/', 'Media\MediaController@cargaEvidencia');
    });
  });
});

Route::post('/login/auth', 'Api\AuthController@login');
//Route::post('/admin/add', 'Admin\UsuariosController@create');
Route::post('/otp/validar', 'Admin\OtpController@validateOtp');
Route::post('/otp/password', 'Admin\OtpController@guardarpassword');
