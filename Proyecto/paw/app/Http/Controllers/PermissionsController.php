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
        if(Auth::user()->can('listar_permiso')){

            $permisoEditar = false;
            if(Auth::user()->can('modificar_permiso')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_permiso')){
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

            $permisos = Permiso::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($permisos as $p ){
                $estado = "Inactivo";
                if($p->estado == "A"){
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
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $permisos = json_encode($array);

            return view('in.negocio.permiso.index')
                    ->with('ruta', 'in.permissions.listar')
                    ->with('title','Tabla de permisos')
                    ->with('subtitle','Permisos')
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
        if(Auth::user()->can('crear_permiso')){
            return view('in.negocio.permiso.create')
                ->with('ruta', 'in.permissions.listar')
                ->with('title','Alta de permiso')
                ->with('subtitle','Permisos');
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
        if(Auth::user()->can('crear_permiso')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $permiso = new Permiso();
            $permiso->display_name = $request->nombre;
            $name = strtolower(str_replace(' ', '_', $request->nombre));
            $permiso->name = $name;
            $permiso->description = $request->descripcion;
            $permiso->save();
        return redirect()->route('in.permissions.listar')->with('success','Permiso ' . $permiso->display_name . ' agregado.');
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
        if(Auth::user()->can('modificar_permiso')){
            $permiso = Permiso::find($id);
            return view('in.negocio.permiso.edit')
                    ->with('ruta', 'in.permissions.listar')
                    ->with('title','Modificación de permiso')
                    ->with('subtitle','Permisos')
                    ->with('permiso',$permiso);
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

        if(Auth::user()->can('modificar_permiso')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));
        
            $permiso = Permiso::find($id);
            $permiso->display_name = $request->nombre;
            $name = strtolower(str_replace(' ', '_', $request->nombre));
            $permiso->name = $name;
            $permiso->description = $request->descripcion;
            $permiso->estado = $request->estado;
            $permiso->save();
            return redirect()->route('in.permissions.listar')->with('success','Permiso ' . $permiso->display_name . ' modificado.');
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
        if(Auth::user()->can('eliminar_permiso')){
            $permiso = Permiso::find($id);
            $permiso->delete();
            return redirect()->route('in.permissions.listar')->with('success', 'Permiso ' . $permiso->display_name . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate)
    {
        $rules =[
            'nombre' => 'required|min:3|max:50',
            'descripcion' => 'required|min:3|max:120'
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
        }

        return $rules;
    }

    private function messages($isUpdate)
    {
        $messages = [ 
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.min' => 'El campo nombre debe contener al menos 3 caracteres.',
            'nombre.max' => 'El campo nombre debe contener 120 caracteres como máximo.',
            'descripcion.required' => 'El campo descripcion es requerido.',
            'descripcion.min' => 'El campo descripcion debe contener al menos 3 caracteres.',
            'descripcion.max' => 'El campo descripcion debe contener 50 caracteres como máximo.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

        return $messages;
    }
}
