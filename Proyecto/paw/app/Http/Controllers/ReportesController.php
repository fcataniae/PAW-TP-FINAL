<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ReportesController extends Controller
{
    public function index(){
    	if(Auth::user()->can('gestionar_reporte')){
			
			$filtros = json_encode($this->getFiltros());

			return view('in.reportes.reporte')
				->with('filtros', $filtros)
				->with('title','Reportes')
				->with('ruta', 'in.reportes')
				->with('subtitle','Reporte');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
	    }
	}
	
	private function getFiltros(){
		
		$filtros = array(
			array("type" => "input", "dataType" => "number", "description" => "Nro", "queryParam" => "id", "min" => "0"),
			array("type" => "input", "dataType" => "number", "description" => "Importe desde", "queryParam" => "importe_desde", "min" => "0"),
			array("type" => "multi-input", "dataType" => "date-between",
				  "objects" => array(
					  array("description" => "Fecha desde", "queryParam" => "fecha_desde"),
					  array("description" => "Fecha hasta", "queryParam" => "fecha_hasta")
				  )
			),
			array("type" => "input+datalist", "dataType" => "dinamic", "description" => "Empleado", "queryParam" => "empleado_id", "datalistUrl" => "/in/empleado"),
			array("type" => "input+datalist", "dataType" => "dinamic", "description" => "Cliente", "queryParam" => "cliente_id", "datalistUrl" => "/in/cliente"),
			array("type" => "input+datalist", "dataType" => "dinamic", "description" => "Forma de pago", "queryParam" => "forma_pago_id", "datalistUrl" => "/in/forma_pago"),
			array("type" => "input+datalist", "dataType" => "static", "description" => "Estado", "queryParam" => "estado", 
				  "datalistData" => array(
					array("descripcion" => "Anulada", "id" => "A"),
					array("descripcion" => "Creada", "id" => "C"),
					array("descripcion" => "Facturada", "id" => "F"),
					array("descripcion" => "Reservada", "id" => "R")
				)
			)
		);

		return $filtros;
	}

}
