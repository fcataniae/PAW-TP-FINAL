<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Cliente as Cliente;
use App\Tipo_Documento as Tipo_Documento;
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
        if(Auth::user()->can('listar_cliente')){

            $permisoEditar = false;
            if(Auth::user()->can('modificar_cliente')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_cliente')){
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
                if($r->estado == "A"){
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

    public function getAll(){
        
        if(Auth::user()->can('gestionar_reporte')){
            $clientes = Cliente::orderBy('id','ASC')->get();
            $array = array();
            foreach($clientes as $cliente ){

                array_push($array,array(
                        'id' => $cliente->id, 
                        'descripcion' => $cliente->nro_documento.' - '.$cliente->nombre.' '.$cliente->apellido 
                    )
                );
            }
            return json_encode($array);
        }else{
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('crear_cliente')){
            $tiposDocumento = [];
            $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->get(); 
            return view('in.negocio.cliente.create')
                    ->with('tiposDocumento',$tiposDocumento);
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
    public function store(Request $request)
    {
        if(Auth::user()->can('crear_cliente')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->email = $request->email;
            $cliente->tipo_documento_id = $request->tipo_documento;
            $cliente->nro_documento = $request->nro_documento;
            $cliente->save();
            return redirect()->route('in.clientes.listar')->with('success','Cliente ' . $cliente->nombre . ' ' . $cliente->apellido . ' agregado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
         }   
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
                    'tipo_documento_id' => $nuevo_cliente->tipo_documento_id,
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
        if(Auth::user()->can('modificar_cliente')){
            $cliente = Cliente::find($id);
            $tiposDocumento = [];
            $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->get(); 
            $json_ld = $this->getJSONLdForCliente($cliente);
            return view('in.negocio.cliente.edit')
                    ->with('cliente',$cliente)
                    ->with('tiposDocumento',$tiposDocumento)
                    ->with('json_ld',$json_ld);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
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
        if(Auth::user()->can('modificar_cliente')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $cliente = Cliente::find($id);
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->email = $request->email;
            $cliente->tipo_documento_id = $request->tipo_documento;
            $cliente->nro_documento = $request->nro_documento;
            $cliente->estado = $request->estado;
            $cliente->save();
            return redirect()->route('in.clientes.listar')->with('success','Cliente ' . $cliente->nombre . ' ' . $cliente->apellido . ' modificado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
         }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('eliminar_cliente')){
            $cliente = Cliente::find($id);
            $cliente->delete();
            return redirect()->route('in.clientes.listar')->with('success', 'Cliente ' . $cliente->nombre . ' ' . $cliente->apellido . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }


    private function rules($isUpdate)
    {
        $tiposDocumento = [];
        $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->where('descripcion','<>','CUIL')->get(); 
        $tiposDocumento_rules = 'required|in:'.$tiposDocumento[0]->id;
        for ($i = 1; $i < sizeof($tiposDocumento); $i++) {
            $tiposDocumento_rules = $tiposDocumento_rules.','.$tiposDocumento[$i]->id;
        }

        $rules = [
            'nombre' => 'required|min:2|max:50',
            'apellido' => 'required|min:2|max:100',
            'tipo_documento' => $tiposDocumento_rules,
            'nro_documento' => 'required|min:3|max:20',
            'email' => 'required|email|max:100'
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
        }

        return $rules;
    }

    private function messages($isUpdate)
    {
        $messages = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.min' => 'El campo nombre debe contener al menos 2 caracteres.',
            'nombre.max' => 'El campo nombre debe contener 50 caracteres como máximo.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'apellido.min' => 'El campo apellido debe contener al menos 2 caracteres.',
            'apellido.max' => 'El campo apellido debe contener 100 caracteres como máximo.',
            'tipo_documento.required' => 'El campo tipo de documento es obligatorio.',
            'tipo_documento.in' => 'Datos invalidos para el campo tipo de documento.',
            'nro_documento.required' => 'El campo nro de documento es obligatorio.',
            'nro_documento.min' => 'El campo nro de documento debe contener al menos 3 caracteres.',
            'nro_documento.max' => 'El campo nro de documento debe contener 20 caracteres como máximo.',
            'email.required' => 'El campo e-mail es obligatorio.',
            'email.email' => 'El campo e-mail no corresponde con una dirección de e-mail válida.',
            'email.max' => 'El campo e-mail debe contener 100 caracteres como máximo.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }
        
        return $messages;
    }

    public function getJSONLdForCliente($cliente){

        $json_ld = array(
            '@context' => 'https://schema.org/',
            '@type' => 'Person',
            'email' => $cliente->email,
            'name' => $cliente->nombre.' '.$cliente->apellido,
        );

        return json_encode($json_ld, JSON_UNESCAPED_SLASHES);
    }
}
