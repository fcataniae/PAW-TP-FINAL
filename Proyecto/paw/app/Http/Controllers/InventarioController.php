<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;

class InventarioController extends Controller
{
    public function index(){
    	if(Auth::user()->can('permisos_repositor')){
    		return view('in.inventario.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
    	}
    }
    public function stock(){
      if(Auth::user()->can('permisos_repositor')){
        return view('in.inventario.stock');
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
    public function update(){
      if(Auth::user()->can('permisos_repositor')){
        return redirect()->route('in.inventario.stock');
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
    public function reposicion(){
      if(Auth::user()->can('permisos_repositor')){
        $controller = new  ProductosController();
        $producto = json_decode($controller->show(Input::get('id')),true);
        return view('in.inventario.reposicion')->with(['data'=>$producto]);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
}
