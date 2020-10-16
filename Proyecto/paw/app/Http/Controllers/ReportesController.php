<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ReportesController extends Controller
{
    public function index(){
    	if(Auth::user()->can('gestionar_reporte')){
    		return view('in.reportes.reporte')
				->with('title','Reportes')
				->with('ruta', 'in.reportes')
				->with('subtitle','Reportes');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
	    }
    }
}
