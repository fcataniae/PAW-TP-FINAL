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
                return redirect()->route('in.facturas.crear');
            }else if(Auth::user()->hasRole('repositor')){
                return redirect()->route('in.inventario.index');
            }
        }]);

        
        Route::get('inventario', 'InventarioController@index')->name('in.inventario.index');
        Route::get('reportes', 'ReportesController@index')->name('in.reportes');
        Route::get('inicio', 'InicioController@index')->name('in.inicio');

        Route::get('inventario/stock', 'InventarioController@stock')->name('in.inventario.stock');
        Route::get('inventario/actualizar', 'InventarioController@reposicion')->name('in.inventario.reposicion');
        Route::get('inventario/productos','ProductosController@showAll')->name('in.producto');
        Route::post('inventario/update','InventarioController@update')->name('in.inventario.update');

        Route::resource('generos','GenerosController');

        Route::resource('categorias','CategoriasController');

        Route::resource('tipos','TiposController');

        Route::resource('talles','TallesController');

        Route::resource('productos','ProductosController');
        Route::get('productos/id/{id}','ProductosController@findById')
            ->name('in.producto.findById');
        Route::get('productos/codigo/{codigo}','ProductosController@findByCodigo')
            ->name('in.producto.findByCodigo');

/*        Route::resource('facturas','FacturaController', [
            'as' => 'in'
        ]);
        */
        Route::get('facturas/crear', 'FacturaController@crear')
            ->name('in.facturas.crear');
        Route::post('facturas/continuar','FacturaController@continuar')
            ->name('in.facturas.continuar');
        Route::get('facturas/reservas','FacturaController@reservas')
            ->name('in.facturas.reservas');
        
        Route::resource('detalles','DetallesController');

        Route::resource('forma_pago','FormaPagoController');

        Route::resource('clientes','DetallesController');

        Route::resource('empleados','EmpleadosController');

        Route::resource('users','UsersController');

        Route::resource('roles','RolesController');

        Route::resource('permissions','PermissionsController');
});
