<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria as Categoria;
use App\Tipo as Tipo;
use Auth;

class TiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('listar_tipo_producto')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_tipo_producto')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_tipo_producto')){
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

            $registros = Tipo::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.tipos.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.tipos.eliminar', ['id' => $r->id]);
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

            return view('in.negocio.tipo.index')
                    ->with('ruta', 'in.tipos.listar')
                    ->with('title','Tabla de tipos de producto')
                    ->with('subtitle','Tipos de producto')
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
        if(Auth::user()->can('crear_tipo_producto')){
            $categorias = [];
            $categorias = Categoria::orderBy('id','ASC')->where('estado', 'A')->get();
            return view('in.negocio.tipo.create')
                    ->with('ruta', 'in.tipos.listar')
                    ->with('title','Alta de tipo de producto')
                    ->with('subtitle','Tipos de producto')
                    ->with('categorias',$categorias);
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
        if(Auth::user()->can('crear_tipo_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $tipo = new Tipo();
            $tipo->descripcion = $request->descripcion;
            $tipo->categoria_id = $request->categoria;
            $tipo->save();
            return redirect()->route('in.tipos.listar')->with('success','Tipo ' . $tipo->descripcion . ' agregado.');
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
        if(Auth::user()->can('modificar_tipo_producto')){
            $tipo = Tipo::find($id);
            $categorias = [];
            $categorias = Categoria::orderBy('id','ASC')->where('estado', 'A')->get();
            return view('in.negocio.tipo.edit')
                    ->with('ruta', 'in.tipos.listar')
                    ->with('title','Modificación de tipo de producto')
                    ->with('subtitle','Tipos de producto')
                    ->with('tipo',$tipo)
                    ->with('categorias',$categorias);
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
        if(Auth::user()->can('modificar_tipo_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $tipo = Tipo::find($id);
            $tipo->descripcion = $request->descripcion;
            $tipo->categoria_id = $request->categoria;
            $tipo->estado = $request->estado;
            $tipo->save();
            return redirect()->route('in.tipos.listar')->with('success','Tipo ' . $tipo->descripcion . ' modificado.');
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
        if(Auth::user()->can('eliminar_tipo_producto')){
            $tipo = Tipo::find($id);
            try{
                $tipo->delete();
            }catch(\Exception $e){
                log::info($e->getMessage()); 
                return redirect()->back()->withErrors('No se puede eliminar el tipo.'); 
            }
            return redirect()->route('in.tipos.listar')->with('success', 'Tipo ' . $tipo->descripcion . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate)
    {

        $categorias = Categoria::where('estado', 'A')->get();

        $categorias_rules = 'required|in:'.$categorias[0]->id;
        for ($x = 1; $x < sizeof($categorias); $x++) {
            $categorias_rules = $categorias_rules.','.$categorias[$x]->id;
        }

        $rules = [
            'descripcion' => 'required|min:2|max:75',
            'categoria' => $categorias_rules
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
        }

        return $rules;
    }

    private function messages($isUpdate)
    {
        $messages = [
            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'descripcion.min' => 'El campo descripcion debe contener al menos 2 caracteres.',
            'descripcion.max' => 'El campo descripcion debe contener 75 caracteres como máximo.',
            'categoria.required' => 'El campo categoria es obligatorio.',
            'categoria.in' => 'Datos invalidos para el campo categoria.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

      return $messages;
    }
}
