<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura as Factura;
use App\Detalle as Detalle;
use Log;

class DetallesController extends Controller
{
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
        $nuevo_detalle = new Detalle();
        $nuevo_detalle->factura_id = $request->factura_id;
        $nuevo_detalle->producto_id = $request->producto_id;
        $nuevo_detalle->cantidad = $request->cantidad;
        $nuevo_detalle->precio_unidad = $request->precio_venta;
        if($nuevo_detalle->save()){
            $array  = array('importe_factura' =>  $nuevo_detalle->factura->importe,
                            'nro_detalle' => $nuevo_detalle->id);
            return json_encode($array);
        }
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
        $detalle = Detalle::find($id);
        $detalle->cantidad = $request->cantidad;
        $detalle->precio_unidad = $request->precio;
        if($detalle->save()){
            $factura = Factura::find($detalle->factura->id);
            return $factura->importe;
        };

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info($id);
        $detalle = Detalle::find($id);
        $factura_id = $detalle->factura->id;
        if($detalle->delete()){
            $factura = Factura::find($factura_id);
            return $factura->importe;
        };

    }
}
