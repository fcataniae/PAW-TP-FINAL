<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria as Categoria;
use App\Genero as Genero;
use Auth;

class CategoriasController extends Controller
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

            $registros = Categoria::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado = "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.categorias.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.categorias.eliminar', ['id' => $r->id]);
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

            return view('in.negocio.categoria.index')
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
            $generos = [];
            $generos = Genero::orderBy('id','ASC')->where('estado', 'A')->get();
            return view('in.negocio.categoria.create')
                    ->with('generos',$generos);
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
            $this->validate($request, $this->rules(), $this->messages());

            $categoria = new Categoria();
            $categoria->descripcion = $request->descripcion;
            $categoria->genero_id = $request->genero;
            $categoria->save();
            return redirect()->route('in.categorias.listar')->with('success','Categoria ' . $categoria->descripcion . ' agregado.');
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
        if(Auth::user()->can('permisos_vendedor')){
            $categoria = Categoria::find($id);
            $categoria->delete();
            return redirect()->route('in.categorias.listar')->with('success', 'Categoria ' . $categoria->descripcion . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules()
    {

        $generos = Genero::where('estado', 'A')->get();

        $generos_rules = 'required|in:'.$generos[0]->id;
        for ($x = 1; $x < sizeof($generos); $x++) {
            $generos_rules = $generos_rules.','.$generos[$x]->id;
        }

        return [
            'descripcion' => 'required|min:2|max:75',
            'genero' => $generos_rules
        ];
    }

    private function messages()
    {
      return [
          'descripcion.required' => 'El campo descripcion es obligatorio.',
          'descripcion.min' => 'El campo descripcion debe contener al menos 2 caracteres.',
          'descripcion.max' => 'El campo descripcion debe contener 75 caracteres como máximo.',
          'genero.required' => 'El campo genero es obligatorio.',
          'genero.in' => 'Datos invalidos para el campo genero.'
      ];
    }
}
