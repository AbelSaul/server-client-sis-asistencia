<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cargos', 'ApiController@apiCargos');
Route::get('empleados', 'ApiController@apiEmpleados');
Route::get('horarios', 'ApiController@apiHorarios');
Route::get('asistencias', 'ApiController@apiAsistencias');
Route::get('cargosEmpleados', 'ApiController@apiNumeroEmpleadosPorCargo');



