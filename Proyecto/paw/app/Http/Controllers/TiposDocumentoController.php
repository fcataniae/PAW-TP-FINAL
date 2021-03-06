<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo_Documento as Tipo_Documento;
use Auth;

class TiposDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('listar_tipo_documento')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_tipo_documento')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_tipo_documento')){
                $permisoEliminar = true;
            }

            $columnas = array(
                array('headerName' => "Codigo", 'field' => "codigo"),
                array('headerName' => "Descripcion", 'field' => "descripcion"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Tipo_Documento::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.tipos_documento.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.tipos_documento.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->id, 
                                            'descripcion' => $r->descripcion,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.tipo_documento.index')
                    ->with('ruta', 'in.tipos_documento.listar')
                    ->with('title','Tabla de tipos de documento')
                    ->with('subtitle','Tipos de documento')
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
        if(Auth::user()->can('crear_tipo_documento')){
            return view('in.negocio.tipo_documento.create')
                ->with('ruta', 'in.tipos_documento.listar')
                ->with('title','Alta de tipo de documento')
                ->with('subtitle','Tipos de documento');
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
        if(Auth::user()->can('crear_tipo_documento')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $tipo_documento = new Tipo_Documento();
            $tipo_documento->descripcion = $request->descripcion;
            $tipo_documento->save();
            return redirect()->route('in.tipos_documento.listar')->with('success','Tipo de documento ' . $tipo_documento->descripcion . ' agregado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
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
        if(Auth::user()->can('modificar_tipo_documento')){
            $tipo_documento = Tipo_Documento::find($id);
            return view('in.negocio.tipo_documento.edit')
                    ->with('ruta', 'in.tipos_documento.listar')
                    ->with('title','Modificación de tipo de documento')
                    ->with('subtitle','Tipos de documento')
                    ->with('tipo_documento', $tipo_documento);
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
        if(Auth::user()->can('modificar_tipo_documento')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $tipo_documento = Tipo_Documento::find($id);
            $tipo_documento->descripcion = $request->descripcion;
            $tipo_documento->estado = $request->estado;
            $tipo_documento->save();
            return redirect()->route('in.tipos_documento.listar')->with('success','Tipo de documento ' . $tipo_documento->descripcion . ' modificado.');
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
        if(Auth::user()->can('eliminar_tipo_documento')){
            $tipo_documento = Tipo_Documento::find($id);
            try{
                $tipo_documento->delete();
            }catch(\Exception $e){
                log::info($e->getMessage()); 
                return redirect()->back()->withErrors('No se puede eliminar el tipo de documento.'); 
            }
            return redirect()->route('in.tipos_documento.listar')->with('success', 'TIpos de documento ' . $tipo_documento->descripcion . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate)
    {
        $rules = [
            'descripcion' => 'required|min:2|max:75',
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
        }

        return $rules;
    }

    private function messages($isUpdate)
    {
        $messages = [ 
            'descripcion.required' => 'El campo descripcion es requerido.',
            'descripcion.min' => 'El campo descripcion debe contener al menos 2 caracteres.',
            'descripcion.max' => 'El campo descripcion debe contener 75 caracteres como máximo.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

        return $messages;
    }
}
