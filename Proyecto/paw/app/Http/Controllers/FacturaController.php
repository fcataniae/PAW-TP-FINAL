<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Auth;
use App\Factura as Factura;
use App\Detalle as Detalle;
use App\Cliente AS Cliente;
use App\Producto as Producto;
use Carbon\Carbon;

class FacturaController extends Controller
{

    public function crear()
    {
        if(Auth::user()->can('permisos_vendedor')){
            $productos = $this->productosAll();
            return view('in.ventas.crear-venta')->with('productos', $productos);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function gestionar(Request $request)
    {
        if(Auth::user()->can('permisos_vendedor')){
            if ($request->has('Crear')) {
                return $this->iniciar($request);
            }else if ($request->has('Confirmar')) {
                return $this->finalizar($request);
            }else if ($request->has('Modificar')) {
                return $this->modificar($request);
            }else if ($request->has('Reservar')){
                return $this->reservar($request);
            }else if($request->has('Continuar')){
                return $this->continuar($request);
            }else if ($request->has('Anular')){
                return $this->anular($request);
            }
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function iniciar(Request $request)
    {

        $nueva_factura = new Factura();
        $nueva_factura->importe = $request->total;
        $nueva_factura->fecha_creacion = Carbon::now();
        $nueva_factura->estado = "C";
        $nueva_factura->empleado_id = Auth::user()->empleado->id;
        $nueva_factura->cliente_id = null;
        $nueva_factura->forma_pago_id = null;
        if($nueva_factura->save()){
            for($i = 0; $i < count($request->producto_id); $i++){
                $nuevo_detalle = new Detalle();
                $nuevo_detalle->factura_id = $nueva_factura->id;;
                $nuevo_detalle->producto_id = $request->producto_id[$i];
                $nuevo_detalle->cantidad = $request->producto_cantidad[$i];
                $nuevo_detalle->precio_unidad = $request->producto_precio[$i];
                $nuevo_detalle->save();
            }
            return redirect()->action('FacturaController@confirmar', ['id' => $nueva_factura->id]);
        }
    }

    private function finalizar(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = "F";
        if($factura->save()){
            return redirect()->route('in.facturas.crear')->with('success','La solicitud ha sido finalizada correctamente.');
        }
    }

    private function modificar(Request $request)
    {
        return redirect()->action('FacturaController@editar', ['id' => $request->id]);
    }

    private function reservar(Request $request)
    {
        if($request->es_cliente == "NO"){
            return redirect()->back()->with('error','Para poder reservar debe ser cliente.');
        }else{
            $cliente = Cliente::find($request->nro_cliente);
            if($cliente == null){
              return redirect()->back()->with('error','No se encuentra al cliente dentro de nuestros registros.');
            }
        }

        $factura = Factura::find($request->id);
        $factura->estado = "R";
        if($factura->save()){
            return redirect()->route('in.facturas.crear')->with('success','La solicitud ha sido reservada correctamente.');
        }
    }

    private function continuar(Request $request){
        return redirect()->action('FacturaController@confirmar', ['id' => $request->nro_factura]);
    }

    private function anular(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = "A";
        if($factura->save()){
            return redirect()->route('in.facturas.crear')->with('success','La solicitud ha sido anulada correctamente.');
        }
    }

    public function reservas()
    {
        //
    }

    public function confirmar($id){
        $factura = Factura::find($id);
        $clientes = Cliente::all();
        return view('in.ventas.confirmar-venta')
                ->with('factura',$factura)
                ->with('clientes',$clientes);
    }


    public function doFilter(){
        $facturas = (new Factura())->newQuery();

        if(Input::get('id')){
          $facturas->where('id', '=', Input::get('id'));
        }
        if(Input::get('empleado_id')){
          $facturas->where('empleado_id', '=', Input::get('empleado_id'));
        }
        if(Input::get('importe_desde')){
          $facturas->where('importe', '>', Input::get('importe_desde'));
        }
        if(Input::get('importe_hasta')){
          $facturas->where('importe', '<', Input::get('importe_hasta'));
        }
        if(Input::get('fecha_desde')){
          $facturas->where('fecha_creacion', '>', date(Input::get('fecha_desde')));
        }
        if(Input::get('fecha_hasta')){
          $facturas->where('fecha_creacion', '<', date(Input::get('fecha_hasta')));
        }
        if(Input::get('cliente_id')){
          $facturas->where('cliente_id', '=', Input::get('cliente_id'));
        }
        if(Input::get('forma_pago_id')){
          $facturas->where('forma_pago_id', '=', Input::get('forma_pago_id'));
        }
        if(Input::get('estado')){
          $facturas->where('estado', '=', Input::get('estado'));
        }
        $facturas = $facturas->get();
        $array = array();
        foreach ($facturas as $factu) {
          $cliente = '';
          $forma = '';
          if($factu->cliente_id){
            $cliente = $factu->cliente->nombre.' '.$factu->cliente->apellido;
          }
          if($factu->forma_pago_id){
            $forma = $factu->formaPago->descripcion ;
          }
          array_push($array,array(
                    'id' =>  $factu->id,
                    'cliente_id' => $cliente,
                    'empleado_id' => $factu->empleado->nombre.' '.$factu->empleado->apellido,
                    'forma_pago_id' => $forma,
                    'estado' => $factu->estado,
                    'fecha_creacion' => $factu->fecha_creacion,
                    'importe' => $factu->importe,
                  ));
        }

      return json_encode($array);
    }

    public function editar($id)
    {
        $factura = Factura::find($id);
        $detalles = Detalle::where('factura_id', '=', $factura->id)->orderBy('id','DESC')->get();
        $productos = $this->productosAll();
        return view('in.ventas.editar-venta')
                ->with('factura',$factura)
                ->with('detalles',$detalles)
                ->with('productos',$productos);
    }

    public function actualizar(Request $request)
    {
        //
    }

    private function productosAll(){
        $productosAll = Producto::all();
        $array =array();
        foreach($productosAll as $producto ){
            array_push($array,array(
                    'id' =>  $producto->id,
                    'descripcion' => $producto->descripcion,
                    'stock' => $producto->stock,
                    'precio_costo' => $producto->precio_costo,
                    'estado' => $producto->estado,
                    'codigo' => $producto->codigo,
                    'precio_venta' => $producto->precio_venta,
                    'talle'=> $producto->talle->descripcion,
                    'tipo' => $producto->tipo->descripcion,
                    'categoria' => $producto->tipo->categoria->descripcion,
                    'genero' => $producto->tipo->categoria->genero->descripcion)
                );
            }
        return json_encode($array);
    }

}
