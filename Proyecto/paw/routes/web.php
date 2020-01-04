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
        Route::get('filter/facturas','FacturaController@doFilter');
        Route::get('forma_pago/all','FormaPagoController@getAll');
        Route::get('empleados/all','EmpleadosController@getAll');
        Route::get('factura/get/detalles/{id}','FacturaController@getDetalleById');


        // empleados, roles y clientes

        Route::get('empleados/listar', 'EmpleadosController@index')->name('in.empleados.listar');
        Route::get('empleados/crear','EmpleadosController@create')->name('in.empleados.crear');
        Route::post('empleados/guardar','EmpleadosController@store')->name('in.empleados.guardar');
        Route::get('empleados/{id}/editar','EmpleadosController@edit')->name('in.empleados.editar');
        Route::put('empleados/{id}/actualizar','EmpleadosController@update')->name('in.empleados.actualizar');
        Route::delete('empleados/{id}/eliminar','EmpleadosController@destroy')->name('in.empleados.eliminar');

        Route::get('permissions/listar', 'PermissionsController@index')->name('in.permissions.listar');
        Route::get('permissions/crear','PermissionsController@create')->name('in.permissions.crear');
        Route::post('permissions/guardar','PermissionsController@store')->name('in.permissions.guardar');
        Route::get('permissions/{id}/editar','PermissionsController@edit')->name('in.permissions.editar');
        Route::put('permissions/{id}/actualizar','PermissionsController@update')->name('in.permissions.actualizar');
        Route::delete('permissions/{id}/eliminar','PermissionsController@destroy')->name('in.permissions.eliminar');

        Route::get('roles/listar', 'RolesController@index')->name('in.roles.listar');
        Route::get('roles/crear','RolesController@create')->name('in.roles.crear');
        Route::post('roles/guardar','RolesController@store')->name('in.roles.guardar');
        Route::get('roles/{id}/editar','RolesController@edit')->name('in.roles.editar');
        Route::put('roles/{id}/actualizar','RolesController@update')->name('in.roles.actualizar');
        Route::delete('roles/{id}/eliminar','RolesController@destroy')->name('in.roles.eliminar');

        Route::get('users/listar', 'UsersController@index')->name('in.users.listar');
        Route::get('users/crear','UsersController@create')->name('in.users.crear');
        Route::post('users/guardar','UsersController@store')->name('in.users.guardar');
        Route::get('users/{id}/editar','UsersController@edit')->name('in.users.editar');
        Route::put('users/{id}/actualizar','UsersController@update')->name('in.users.actualizar');
        Route::delete('users/{id}/eliminar','UsersController@destroy')->name('in.users.eliminar');

        Route::get('clientes/listar', 'ClientesController@index')->name('in.clientes.listar');
        Route::get('clientes/crear','ClientesController@create')->name('in.clientes.crear');
        Route::post('clientes/guardar','ClientesController@store')->name('in.clientes.guardar');
        Route::get('clientes/{id}/editar','ClientesController@edit')->name('in.clientes.editar');
        Route::put('clientes/{id}/actualizar','ClientesController@update')->name('in.clientes.actualizar');
        Route::delete('clientes/{id}/eliminar','ClientesController@destroy')->name('in.clientes.eliminar');
        Route::post('clientes-ajax','ClientesController@storeAjax')->name('in.clientes.storeAjax');

        // parametria y productos

        Route::get('generos/listar', 'CategoriasController@index')->name('in.generos.listar');
        Route::get('generos/crear','CategoriasController@create')->name('in.generos.crear');
        Route::post('generos/guardar','CategoriasController@store')->name('in.generos.guardar');
        Route::get('generos/{id}/editar','CategoriasController@edit')->name('in.generos.editar');
        Route::put('generos/{id}/actualizar','CategoriasController@update')->name('in.generos.actualizar');
        Route::delete('generos/{id}/eliminar','CategoriasController@destroy')->name('in.generos.eliminar');

        Route::get('categorias/listar', 'CategoriasController@index')->name('in.categorias.listar');
        Route::get('categorias/crear','CategoriasController@create')->name('in.categorias.crear');
        Route::post('categorias/guardar','CategoriasController@store')->name('in.categorias.guardar');
        Route::get('categorias/{id}/editar','CategoriasController@edit')->name('in.categorias.editar');
        Route::put('categorias/{id}/actualizar','CategoriasController@update')->name('in.categorias.actualizar');
        Route::delete('categorias/{id}/eliminar','CategoriasController@destroy')->name('in.categorias.eliminar');

        Route::get('tipos/listar', 'TiposController@index')->name('in.tipos.listar');
        Route::get('tipos/crear','TiposController@create')->name('in.tipos.crear');
        Route::post('tipos/guardar','TiposController@store')->name('in.tipos.guardar');
        Route::get('tipos/{id}/editar','TiposController@edit')->name('in.tipos.editar');
        Route::put('tipos/{id}/actualizar','TiposController@update')->name('in.tipos.actualizar');
        Route::delete('tipos/{id}/eliminar','TiposController@destroy')->name('in.tipos.eliminar');

        Route::get('talles/listar', 'TallesController@index')->name('in.talles.listar');
        Route::get('talles/crear','TallesController@create')->name('in.talles.crear');
        Route::post('talles/guardar','TallesController@store')->name('in.talles.guardar');
        Route::get('talles/{id}/editar','TallesController@edit')->name('in.talles.editar');
        Route::put('talles/{id}/actualizar','TallesController@update')->name('in.talles.actualizar');
        Route::delete('talles/{id}/eliminar','TallesController@destroy')->name('in.talles.eliminar');

        Route::get('productos/listar', 'ProductosController@index')->name('in.productos.listar');
        Route::get('productos/crear','ProductosController@create')->name('in.productos.crear');
        Route::post('productos/guardar','ProductosController@store')->name('in.productos.guardar');
        Route::get('productos/{id}/editar','ProductosController@edit')->name('in.productos.editar');
        Route::put('productos/{id}/actualizar','ProductosController@update')->name('in.productos.actualizar');
        Route::delete('productos/{id}/eliminar','ProductosController@destroy')->name('in.productos.eliminar');

        Route::get('forma_pago/listar', 'FormaPagoController@index')->name('in.forma_pago.listar');
        Route::get('forma_pago/crear','FormaPagoController@create')->name('in.forma_pago.crear');
        Route::post('forma_pago/guardar','FormaPagoController@store')->name('in.forma_pago.guardar');
        Route::get('forma_pago/{id}/editar','FormaPagoController@edit')->name('in.forma_pago.editar');
        Route::put('forma_pago/{id}/actualizar','FormaPagoController@update')->name('in.forma_pago.actualizar');
        Route::delete('forma_pago/{id}/eliminar','FormaPagoController@destroy')->name('in.forma_pago.eliminar');

        Route::get('tipos_documento/listar', 'TiposDocumentoController@index')->name('in.tipos_documento.listar');
        Route::get('tipos_documento/crear','TiposDocumentoController@create')->name('in.tipos_documento.crear');
        Route::post('tipos_documento/guardar','TiposDocumentoController@store')->name('in.tipos_documento.guardar');
        Route::get('tipos_documento/{id}/editar','TiposDocumentoController@edit')->name('in.tipos_documento.editar');
        Route::put('tipos_documento/{id}/actualizar','TiposDocumentoController@update')->name('in.tipos_documento.actualizar');
        Route::delete('tipos_documento/{id}/eliminar','TiposDocumentoController@destroy')->name('in.tipos_documento.eliminar');

        //facturacion y detalles
        
        Route::get('facturas/crear', 'FacturaController@crear')->name('in.facturas.crear');
        Route::post('facturas/gestionar','FacturaController@gestionar')->name('in.facturas.gestionar');
        Route::get('facturas/{id}/confirmar','FacturaController@confirmar')->name('in.facturas.confirmar');
        Route::get('facturas/{id}/editar','FacturaController@editar')->name('in.facturas.editar');
        Route::get('facturas/{id}/comprobante','FacturaController@comprobante')->name('in.facturas.comprobante');
        Route::get('facturas/reservas','FacturaController@reservas')->name('in.facturas.reservas');

        Route::post('detalles','DetallesController@store')->name('in.detalles.store');
        Route::post('detalles/{id}','DetallesController@update')->name('in.detalles.update');
        Route::delete('detalles/{id}/destroy','DetallesController@destroy')->name('in.detalles.destroy');

});
