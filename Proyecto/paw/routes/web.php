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

		// pagina para mostrar cuando no se tiene acceso a un lugar
        Route::get('sinpermisos', ['as' => 'in.sinpermisos.sinpermisos', function () {
            return view('in.sinpermisos.sinpermisos');
        }]);

        //Ruta para redirección cuando no tiene permiso.
        Route::get('/', ['as' => 'in', function () {
            if(Auth::user()->hasRole('administrador') || Auth::user()->hasRole('superusuario')) {
                return redirect()->route('in.reportes');
            }else if(Auth::user()->hasRole('vendedor')) {
                return redirect()->route('in.ventas');
            }else if(Auth::user()->hasRole('repositor')){
                return redirect()->route('in.inventario');
            }
        }]);

        Route::get('ventas', 'VentasController@index')->name('in.ventas');
        Route::get('inventario', 'InventarioController@index')->name('in.inventario');
        Route::get('reportes', 'ReportesController@index')->name('in.reportes');
        Route::get('inicio', 'InicioController@index')->name('in.inicio');
});
