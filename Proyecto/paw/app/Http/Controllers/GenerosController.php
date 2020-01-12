<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genero as Genero;
use Auth;

class GenerosController extends Controller
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
                array('headerName' => "Descripcion", 'field' => "descripcion"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Genero::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.generos.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.generos.eliminar', ['id' => $r->id]);
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

            return view('in.negocio.genero.index')
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
        if(Auth::user()->can('permisos_vendedor')){
            return view('in.negocio.genero.create');
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
        if(Auth::user()->can('permisos_vendedor')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $genero = new Genero();
            $genero->descripcion = $request->descripcion;
            $genero->save();
            return redirect()->route('in.generos.listar')->with('success','Genero ' . $genero->descripcion . ' agregado.');
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
        if(Auth::user()->can('permisos_vendedor')){
            $genero = Genero::find($id);
            return view('in.negocio.genero.edit')
                    ->with('genero',$genero);
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
        if(Auth::user()->can('permisos_vendedor')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $genero = Genero::find($id);
            $genero->descripcion = $request->descripcion;
            $genero->estado = $request->estado;
            $genero->save();
            return redirect()->route('in.generos.listar')->with('success','Genero ' . $genero->descripcion . ' modificado.');
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
        if(Auth::user()->can('permisos_vendedor')){
            $genero = Genero::find($id);
            $genero->delete();
            return redirect()->route('in.generos.listar')->with('success', 'Genero ' . $genero->descripcion . ' eliminado.');
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
