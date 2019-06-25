<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Factura as Factura;
use App\Detalle as Detalle;
use Carbon\Carbon;

class FacturaController extends Controller
{
    
    public function crear()
    {
        if(Auth::user()->can('permisos_vendedor')){
            return view('in.ventas.iniciar-venta');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function continuar(Request $request)
    {   
        if(Auth::user()->can('permisos_vendedor')){
            if ($request->has('Crear')) {
                return $this->iniciar($request);
            }else if ($request->has('Confirmar')) {
                return $this->confirmar($request);
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

    public function iniciar(Request $request)
    {
        
        $nueva_factura = new Factura();
        $nueva_factura->importe = $request->total;
        $nueva_factura->fecha_creacion = Carbon::now();
        $nueva_factura->estado = "C";
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
                    return view('in.ventas.confirmar-venta')
                                ->with('factura',$nueva_factura);
                }
            }
        }
    }

    private function confirmar(Request $request)
    {
        //
    }

    private function modificar(Request $request)
    {
        //
    }

    private function reservar(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = "R";
        if($factura->save()){
            return view('in.ventas.iniciar-venta');
        }
    }

    private function anular(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = "A";
        if($factura->save()){
            return view('in.ventas.iniciar-venta');
        }
    }

    private function reservas()
    {
        //
    }
}
