<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use ProductosController;

class InventarioController extends Controller
{
    public function index(){
    	if(Auth::user()->can('gestionar_inventario')){
    		return view('in.inventario.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
    	}
    }

    public function stock(){
      if(Auth::user()->can('gestionar_inventario')){

        $data = app('App\Http\Controllers\ProductosController')->showAll();

        return view('in.inventario.stock')
          ->with('columnas', json_encode($data['columnas']))
          ->with('registros',json_encode($data['registros']));
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }

    public function update(Request $request){
      if(Auth::user()->can('gestionar_inventario')){
        $this->validate($request,[
               'id' => 'required',
               'stock' => 'required|numeric|min:0',
               'comentario' => 'required',
           ]);

        $act = app('App\Http\Controllers\ProductosController')->updateStock($request->post('id'),$request->post('stock'),$request->post('comentario'),Auth::user()->name);
        if($act){
          return redirect()->route('in.inventario.stock');
        }else {
          return redirect()->back()->withErrors("No se pudo actualizar el stock!");
        }
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }

    public function reposicion(){
      if(Auth::user()->can('gestionar_inventario')){
        $prod = app('App\Http\Controllers\ProductosController')->findById(Input::get('id'));
        $producto = json_decode($prod,true);
        return view('in.inventario.reposicion')->with(['data'=>$producto]);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
}
