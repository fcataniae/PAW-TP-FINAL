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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmar(Request $request)
    {
        if(Auth::user()->can('permisos_vendedor')){
            $nueva_factura = new Factura();
            $nueva_factura->importe = $request->total;
            $nueva_factura->fecha_creacion = Carbon::now();
            $nueva_factura->estado = "C";
            $nueva_factura->empleado_id = Auth::user()->empleado->id;
            $nueva_factura->cliente_id = null;
            $nueva_factura->forma_pago_id = null;
            if($nueva_factura->save()){
                $detalles = (count($request->all()) - 4) / 7;
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
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }  



    public function finalizar(Request $request)
    {
        //
    }

    public function reservas()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
