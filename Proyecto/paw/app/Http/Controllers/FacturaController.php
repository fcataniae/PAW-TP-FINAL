<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Factura as Factura;
use App\Detalle as Detalle;
use App\Cliente AS Cliente;
use Carbon\Carbon;

class FacturaController extends Controller
{
    
    public function crear()
    {
        if(Auth::user()->can('permisos_vendedor')){
            return view('in.ventas.crear-venta');
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
        /*$nueva_factura->importe = $request->total;
        $nueva_factura->fecha_creacion = Carbon::now();
        $nueva_factura->estado = "C";*/
        $nueva_factura->empleado_id = Auth::user()->empleado->id;
        $nueva_factura->cliente_id = null;
        $nueva_factura->forma_pago_id = null;
        if($nueva_factura->save()){
            $detalles = (count($request->all()) - 5) / 7;
            for($i = 1; $i <= $detalles; $i++){
                $nuevo_detalle = new Detalle();
                $nuevo_detalle->factura_id = $nueva_factura->id;;
                $nuevo_detalle->producto_id = $request["id_" . $i];
                $nuevo_detalle->cantidad = $request["cantidad_" . $i];
                $nuevo_detalle->precio_unidad = $request["precio_" . $i];
                if($nuevo_detalle->save()){
                    return redirect()->action('FacturaController@confirmar', ['id' => $nueva_factura->id]);
                }
            }
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
        return view('in.ventas.confirmar-venta')->with('factura',$factura);
    }

    public function editar($id)
    {
        $factura = Factura::find($id);
        $detalles = Detalle::where('factura_id', '=', $factura->id)->orderBy('id','DESC')->get();
        return view('in.ventas.editar-venta')
                ->with('factura',$factura)
                ->with('detalles',$detalles);
    }

    public function actualizar(Request $request)
    {
        //
    }

}
