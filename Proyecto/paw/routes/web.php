<?php
use App\User;
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

Route::get('/', function () {
    $user = User::find(1);
    echo $user->empleado->tipoDocumento;
    echo '<br>';
    if($user->hasRole('admin')){
		echo 'Tiene el rol';
    }else{
    	echo 'no tiene el rol';
    }
    echo '<br>';
    if($user->can('crear_usuarios')){
    	echo 'Tiene el permiso';
    }else{
    	echo 'No tiene el permiso';
    }

});
