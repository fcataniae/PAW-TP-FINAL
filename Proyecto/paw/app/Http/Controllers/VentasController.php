<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class VentasController extends Controller
{
    public function index(){
    	if(Auth::user()->can('permisos_vendedor')){
    		return view('in.ventas.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
    	}
    }
}
