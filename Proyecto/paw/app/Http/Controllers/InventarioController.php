<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;

use App\Remito as Remito;
use App\RemitoDetalle as RemitoDetalle;

class InventarioController extends Controller
{
    protected $controller;
    protected $fcontroller;

    public function __construct(){
      $this->controller = new ProductosController();
      $this->fcontroller = new FacturaController();
    }

    public function index(){

    	if(Auth::user()->can('gestionar_inventario')){
    		return view('in.inventario.index');
    	}else{
    		return redirect()->route('in.sinpermisos.sinpermisos');
    	}
    }

    public function stock(){

      if(Auth::user()->can('gestionar_inventario')){

        $filtros = json_encode($this->getFiltros());

        return view('in.inventario.stock')
          ->with('subtitle','Inventario')
          ->with('title','Control de Stock')
          ->with('ruta', 'in.inventario.stock')
          ->with('filtros', $filtros);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }

    private function getFiltros(){
      
      $filtros = array(
        array("type" => "input", "dataType" => "text", "description" => "Codigo", "queryParam" => "codigo"),
        array("type" => "input", "dataType" => "text", "description" => "Descripcion", "queryParam" => "descripcion"),
        array("type" => "input", "dataType" => "number", "description" => "Stock hasta", "queryParam" => "stock_hasta", "min" => "0"),
        array("type" => "input", "dataType" => "number", "description" => "Stock desde", "queryParam" => "stock_desde", "min" => "0"),
        array("type" => "input+datalist", "dataType" => "static", "description" => "Estado", "queryParam" => "estado", 
              "datalistData" => array(
                array("descripcion" => "Activo", "id" => "A"),
                array("descripcion" => "Inactivo", "id" => "I")
            )
        )
    );

    return $filtros;
    }

    public function doFilter(Request $request){

      if(Auth::user()->can('gestionar_inventario')){

        $data = $this->controller->doFilter2($request);

        return $data;
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

        $act = $this->controller->updateStock($request->post('id'),$request->post('stock'),$request->post('comentario'),Auth::user()->name);
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

        $productos = $this->fcontroller->productosAll();
        return view('in.inventario.reposicion')
        ->with('subtitle','Inventario')
        ->with('title','Actualizar Stock')
        ->with('ruta', 'in.inventario.stock')
        ->with('productos',$productos);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }

    public function guardarRemito(Request $request){
      if(Auth::user()->can('gestionar_inventario')){
        
        return $this->saveRemito($request);
      }else{
        return redirect()->route('in.sinpermisos.sinpermisos');
      }
    }

    private function saveRemito(Request $request){

      $allowedMimeTypes = ['image/jpeg','image/png','image/jpg','application/pdf'];
      if($request->producto_id == null || count($request->producto_id) == 0){
          return redirect()->back()->withErrors('No se encontraron productos asociado a la compra.');
      }

      for($i = 0; $i < count($request->producto_id); $i++){
          if($request->producto_cantidad[$i] <= 0){
            return redirect()->back()->withErrors('Se detectaron productos sin cantidad definida.'); 
          }
      }
      if(!$request->hasFile('remito_img') || !$request->file('remito_img')->isValid() || !in_array($request->file('remito_img')->getMimeType(),$allowedMimeTypes)){
        return redirect()->back()->withErrors('La imagen cargada no es valida.'); 
      }
      
      $remito = new Remito();
      $remito->nro_remito = $request->nro_remito;
      $remito->importe = 0;
      $remito->fecha_creacion = Carbon::now();
      $remito->empleado_id =  Auth::user()->empleado->id;
      $remito->estado = 'I';
      $logo = file_get_contents($request->file('remito_img'));
      $base64 = base64_encode($logo);
      $remito->image = $base64;
      if($remito->save() ){
        $this->saveArchivoRemito($remito, $request);
        for($i = 0; $i < count($request->producto_id); $i++){
          $nuevo_detalle = new RemitoDetalle();
          $nuevo_detalle->remito_id = $remito->id;;
          $nuevo_detalle->producto_id = $request->producto_id[$i];
          $nuevo_detalle->cantidad = $request->producto_cantidad[$i];
          $nuevo_detalle->fecha_creacion = Carbon::now();
          $nuevo_detalle->save();
        }
      }
      return redirect()->route('in.inventario.stock')->with('success','Se dio de alta el remito y se actualizo el stock!');
    }

    private function saveArchivoRemito($remito, $request){
      if ($request->hasFile('remito_img')) {
        $file = $request->file('remito_img');
        $name = 'Remito_Id_' . $remito->id .'_Nro_'. $remito->nro_remito .'.'. $file->getClientOriginalExtension();
        $path = public_path(). '/img/remitos/';
        $file->move($path, $name);
      }
    }
}
