<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function reposicion(){
      if(Auth::user()->can('permisos_repositor')){
        return view('in.inventario.reposicion');
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }
}
