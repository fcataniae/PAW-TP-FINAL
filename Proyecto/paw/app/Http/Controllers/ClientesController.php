<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente as Cliente;
use Log;

class ClientesController extends Controller
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
    }

    public function storeAjax(Request $request)
    {
        Log::info($request);
        $nuevo_cliente = new Cliente();
        $nuevo_cliente->tipo_documento_id = $request->tipo_documento;
        $nuevo_cliente->nro_documento = $request->nro_documento;
        $nuevo_cliente->nombre = $request->nombre;
        $nuevo_cliente->apellido = $request->apellido;
        $nuevo_cliente->estado = "A";
        if($nuevo_cliente->save()){
            $array = array(
                    'id' =>  $cliente->id,
                    'tipo_documento' => $cliente->tipoDocumento->descripcion,
                    'nro_documento' => $cliente->nro_documento,
                    'nombre' => $cliente->nombre,
                    'apellido' => $cliente->apellido);
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
