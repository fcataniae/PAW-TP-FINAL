<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission as Permiso;
use Auth;

class PermissionsController extends Controller
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
                array('headerName' => "Descripcion", 'field' => "description"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $permisos = Permiso::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($permisos as $p ){
                $estado = "Inactivo";
                if($p->estado = "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.permissions.editar', ['id' => $p->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.permissions.eliminar', ['id' => $p->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $p->id, 
                                            'display_name' => $p->display_name, 
                                            'description' => $p->description,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $permisos = json_encode($array);

            return view('in.negocio.permiso.index')
                    ->with('columnas', $columnas)
                    ->with('permisos',$permisos);
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
        dd("Registros a editar: " . $id);
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
        dd("Registros a eliminar: " . $id);
    }
}
