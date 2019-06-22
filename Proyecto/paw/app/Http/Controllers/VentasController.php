<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class VentasController extends Controller
{
    public function index(){
    	if(Auth::user()->can('roles_vendedor')){
    		return view('in.ventas.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
    	}
    }
}
