<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente as Cliente;
use Log;
use Auth;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('permisos_vendedor')){

            $permisoEditar = false;
            if(Auth::user()->can('permisos_vendedor')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('permisos_vendedor')){
                $permisoEliminar = true;
            }

            $columnas = array(
                array('headerName' => "Codigo", 'field' => "codigo"),
                array('headerName' => "Nombre", 'field' => "nombre"),
                array('headerName' => "Apellido", 'field' => "apellido"),
                array('headerName' => "Documento", 'field' => "nro_documento"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Cliente::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado = "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.clientes.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.clientes.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->id, 
                                            'nombre' => $r->nombre, 
                                            'apellido' => $r->apellido,
                                            'nro_documento' => $r->nro_documento,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.cliente.index')
                    ->with('columnas', $columnas)
                    ->with('registros',$registros);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
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
        Log::info($request);   
    }

    public function storeAjax(Request $request)
    {
        if($request->tipo_documento == null || $request->nro_documento == null || $request->nombre == null || $request->apellido == null){            
            throw new Exception('Campos nulos.');
        }
        $nuevo_cliente = new Cliente();
        $nuevo_cliente->tipo_documento_id = $request->tipo_documento;
        $nuevo_cliente->nro_documento = $request->nro_documento;
        $nuevo_cliente->nombre = $request->nombre;
        $nuevo_cliente->apellido = $request->apellido;
        $nuevo_cliente->email = null;
        $nuevo_cliente->estado = "A";
        if($nuevo_cliente->save()){
            $array = array(
                    'id' =>  $nuevo_cliente->id,
                    'tipo_documento' => $nuevo_cliente->tipoDocumento->descripcion,
                    'nro_documento' => $nuevo_cliente->nro_documento,
                    'nombre' => $nuevo_cliente->nombre,
                    'apellido' => $nuevo_cliente->apellido);
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
