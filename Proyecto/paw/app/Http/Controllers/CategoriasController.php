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
        if(Auth::user()->can('listar_categoria_producto')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_categoria_producto')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_categoria_producto')){
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
                if($r->estado == "A"){
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
                    ->with('title','Categoria de producto')
                    ->with('subtitle','Negocio')
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
        if(Auth::user()->can('crear_categoria_producto')){
            $generos = [];
            $generos = Genero::orderBy('id','ASC')->where('estado', 'A')->get();
            return view('in.negocio.categoria.create')
                    ->with('ruta', 'in.categorias.listar')
                    ->with('title','Alta categoria de producto')
                    ->with('subtitle','Categoria de producto')
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
        if(Auth::user()->can('crear_categoria_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

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
        if(Auth::user()->can('modificar_categoria_producto')){
            $categoria = Categoria::find($id);
            $generos = [];
            $generos = Genero::orderBy('id','ASC')->where('estado', 'A')->get();
            return view('in.negocio.categoria.edit')
                    ->with('ruta', 'in.categorias.listar')
                    ->with('title','Modificación categoria de producto')
                    ->with('subtitle','Categoria')
                    ->with('categoria',$categoria)
                    ->with('generos',$generos);
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
        if(Auth::user()->can('modificar_categoria_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $categoria = Categoria::find($id);
            $categoria->descripcion = $request->descripcion;
            $categoria->genero_id = $request->genero;
            $categoria->estado = $request->estado;
            $categoria->save();
            return redirect()->route('in.categorias.listar')->with('success','Categoria ' . $categoria->descripcion . ' modificada.');
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
        if(Auth::user()->can('eliminar_categoria_producto')){
            $categoria = Categoria::find($id);
            $categoria->delete();
            return redirect()->route('in.categorias.listar')->with('success', 'Categoria ' . $categoria->descripcion . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate)
    {
        $generos = Genero::where('estado', 'A')->get();

        $generos_rules = 'required|in:'.$generos[0]->id;
        for ($x = 1; $x < sizeof($generos); $x++) {
            $generos_rules = $generos_rules.','.$generos[$x]->id;
        }

        $rules = [
            'descripcion' => 'required|min:2|max:75',
            'genero' => $generos_rules
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
            'genero.required' => 'El campo genero es obligatorio.',
            'genero.in' => 'Datos invalidos para el campo genero.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

        return $messages; 
    }
}
