<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ReportesController extends Controller
{
    public function index(){
    	if(Auth::user()->can('gestionar_reporte')){
    		return view('in.reportes.index')
				->with('title','Reportes')
				->with('subtitle','');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
	    }
    }
}
