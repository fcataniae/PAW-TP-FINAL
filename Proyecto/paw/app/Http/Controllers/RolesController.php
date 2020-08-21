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
        if(Auth::user()->can('listar_rol')){

            $permisoEditar = false;
            if(Auth::user()->can('modificar_rol')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_rol')){
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

            $registros = Rol::orderBy('id','ASC')->where('name', '<>', 'superusuario')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
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
                    ->with('title','Roles')
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
        if(Auth::user()->can('crear_rol')){
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
            return view('in.negocio.rol.create')
                    ->with('ruta', 'in.roles.listar')
                    ->with('title','Alta de rol')
                    ->with('subtitle','Roles')
                    ->with('permisos',$permisos);
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
        if(Auth::user()->can('crear_rol')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $rol = new Rol();
            $rol->display_name = $request->nombre;
            $name = strtolower(str_replace(' ', '_', $request->nombre));
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
        if(Auth::user()->can('modificar_rol')){
            $rol = Rol::find($id);

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

            // necesito el array de los permisos q contiene (solo los id's)
            $my_permisos = $rol->permissions->pluck('id')->toArray(); // pasa un objeto a un array
            return view('in.negocio.rol.edit')
                    ->with('ruta', 'in.roles.listar')
                    ->with('title','Modificación de rol')
                    ->with('subtitle','Roles')
                    ->with('rol',$rol)
                    ->with('permisos', $permisos)
                    ->with('my_permisos',$my_permisos);
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
        if(Auth::user()->can('modificar_rol')){
            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $rol = Rol::find($id);
            $rol->display_name = $request->nombre;
            $name = strtolower(str_replace(' ', '_', $request->nombre));
            $rol->name = $name;
            $rol->description = $request->descripcion;
            $rol->estado = $request->estado;
            $rol->save();

            //sincronizo con la tabla pivot
            $permisos = $request->permisos;
            $rol->permissions()->sync($permisos);
            return redirect()->route('in.roles.listar')->with('success','Rol ' . $rol->display_name . ' modificado.');
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
        if(Auth::user()->can('eliminar_rol')){
            $rol = Rol::find($id);
            $rol->delete();
            return redirect()->route('in.roles.listar')->with('success', 'Rol ' . $rol->display_name . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate)
    {
        $rules =[
            'nombre' => 'required|min:3|max:50',
            'descripcion' => 'required|min:3|max:120',
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
