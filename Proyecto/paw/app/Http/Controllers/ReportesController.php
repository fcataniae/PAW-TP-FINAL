<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ReportesController extends Controller
{
    public function index(){
    	if(Auth::user()->can('roles_administrador')){
    		return view('in.reportes.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
	    }
    }
}
