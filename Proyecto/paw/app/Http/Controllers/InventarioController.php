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
    public function update(Request $request){
      if(Auth::user()->can('permisos_repositor')){
        $this->validate($request,[
               'id' => 'required',
               'stock' => 'required|numeric|min:0',
               'comentario' => 'required',
           ]);

        $controller = new ProductosController();
        if($controller->updateStock($request->post('id'),$request->post('stock'),$request->post('comentario'),Auth::user()->name)){
          return redirect()->route('in.inventario.stock');
        }else {
          return redirect()->back()->withErrors("No se pudo actualizar el stock!");
        }
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
    public function reposicion(){
      if(Auth::user()->can('permisos_repositor')){
        $controller = new  ProductosController();
        $producto = json_decode($controller->findById(Input::get('id')),true);
        return view('in.inventario.reposicion')->with(['data'=>$producto]);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
}
