<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Llamadas al controlador Login*/
Route::get('/', 'Auth\LoginController@showLogin')->name('auth.login'); // Mostrar login
Route::get('login', 'Auth\LoginController@showLogin')->name('auth.login'); // Mostrar login
Route::post('login', 'Auth\LoginController@postLogin')->name('auth.login'); // Verificar datos
Route::post('logout', 'Auth\LoginController@postLogout')->name('auth.logout'); // Finalizar sesión

/*Rutas para usuarios logueados*/
Route::group(['prefix' => 'in', 'middleware' => 'auth'], function(){
        Route::get('inicio', 'InicioController@index')->name('in.inicio');
});    