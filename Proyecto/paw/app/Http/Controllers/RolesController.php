<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role as Rol;
use App\Permission as Permiso;
use Auth;

class RolesController extends Controller
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
                array('headerName' => "Nombre", 'field' => "display_name"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Rol::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado = "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.roles.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.roles.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->id, 
                                            'display_name' => $r->display_name, 
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.rol.index')
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
            $permisos = [];
            if (Auth::user()->hasRole('superusuario')) {
                $permisos = Permiso::orderBy('id','ASC')->where('estado', 'A')->get(); 
            }
            else {
                $permisos = Permiso::orderBy('id','ASC')
                                ->where('estado', 'A')
                                ->where('name','<>','crear_permiso')
                                ->where('name','<>','eliminar_permiso')
                                ->where('name','<>','modificar_permiso')->get();
            }
            return view('in.negocio.rol.create')->with('permisos',$permisos);
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

            $this->validate($request, [
                'nombre' => 'required|min:3|max:50',
                'descripcion' => 'required|min:3|max:120',
            ],[ 
                'nombre.required' => 'El campo nombre es requerido.',
                'nombre.min' => 'El campo nombre debe contener al menos 3 caracteres.',
                'nombre.max' => 'El campo nombre debe contener 50 caracteres como máximo.',
                'descripcion.required' => 'El campo descripcion es requerido.',
                'descripcion.min' => 'El campo descripcion debe contener al menos 3 caracteres.',
                'descripcion.max' => 'El campo descripcion debe contener 50 caracteres como máximo.'
            ]);

            $rol = new Rol();
            $rol->display_name = $request->nombre;
            $name = str_replace(' ', '_', $request->nombre);
            $rol->name = $name;
            $rol->description = $request->descripcion;
            $rol->save();

            //sincronizo con la tabla pivot
            $permisos = $request->permisos;
            $rol->permissions()->sync($permisos);
            return redirect()->route('in.roles.listar')->with('success','Rol ' . $rol->display_name . ' agregado.');
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
            $rol = Rol::find($id);
            $rol->delete();
            return redirect()->route('in.roles.listar')->with('success', 'Rol ' . $rol->display_name . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }
}
