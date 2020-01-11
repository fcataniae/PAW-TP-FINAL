<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as Usuario;
use App\Empleado as Empleado;
use App\Role as Rol;
use Auth;

class UsersController extends Controller
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
                array('headerName' => "Nombre", 'field' => "name"),
                array('headerName' => "E-Mail", 'field' => "email"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Usuario::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado = "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.users.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.users.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->id, 
                                            'name' => $r->name, 
                                            'email' => $r->email,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.usuario.index')
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
            $empleados = [];
            $empleados = Empleado::orderBy('id','ASC')->where('estado', 'A')->get(); 
            $roles = [];
            $roles = Rol::orderBy('id','ASC')->where('estado', 'A')->get(); 
            return view('in.negocio.usuario.create')
                ->with('empleados',$empleados)
                ->with('roles',$roles);
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
            $this->validate($request, $this->rules($request->_method == 'PUT', null), 
                                    $this->messages($request->_method == 'PUT'));

            $usuario = new Usuario();
            $usuario->name = $request->name;
            $usuario->empleado_id = $request->empleado;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password); // se encripta la contraseña
            $usuario->save();

            //sincronizo con la tabla pivot
            $roles = $request->roles;
            $usuario->roles()->sync($roles);

            return redirect()->route('in.users.listar')->with('success','Usuario ' . $usuario->name . ' agregado.');
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
            $usuario = Usuario::find($id);

            $empleados = [];
            $empleados = Empleado::orderBy('id','ASC')->where('estado', 'A')->get(); 
            $roles = [];
            $roles = Rol::orderBy('id','ASC')->where('estado', 'A')->get(); 

            // necesito el array de los permisos q contiene (solo los id's)
            $my_roles = $usuario->roles->pluck('id')->toArray(); // pasa un objeto a un array
            return view('in.negocio.usuario.edit')
                    ->with('usuario',$usuario)
                    ->with('empleados', $empleados)
                    ->with('roles', $roles)
                    ->with('my_roles',$my_roles);
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
            $this->validate($request, $this->rules($request->_method == 'PUT',$id), 
                                    $this->messages($request->_method == 'PUT'));

            $usuario = Usuario::find($id);
            $usuario->name = $request->name;
            $usuario->empleado_id = $request->empleado;
            $usuario->email = $request->email;
            $usuario->estado = $request->estado;
            $usuario->save();

            //sincronizo con la tabla pivot
            $roles = $request->roles;
            $usuario->roles()->sync($roles);

            return redirect()->route('in.users.listar')->with('success','Usuario ' . $usuario->name . ' modificado.');
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
            $usuario = Usuario::find($id);
            $usuario->delete();
            return redirect()->route('in.users.listar')->with('success', 'Usuario ' . $usuario->name . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate, $userId)
    {
        //Se traen los roles y personas disponibles para hacer las validaciones.
        if (Auth::user()->hasRole('super_usuario')) {
            $roles = Rol::where('estado', 'A')->get();
        } else {
            $roles = Rol::where('estado', 'A')->where('name','<>','super_usuario')->get();
        }

        $empleados = Empleado::where('estado', 'A')->get();

        $roles_disponibles = 'required|array|in:'.$roles[0]->id;
        for ($x = 1; $x < sizeof($roles); $x++) {
            $roles_disponibles = $roles_disponibles.','.$roles[$x]->id;
        }

        $empleados_disponibles = 'required|in:'.$empleados[0]->id;
        for ($y = 1; $y < sizeof($empleados); $y++) {
            $empleados_disponibles = $empleados_disponibles.','.$empleados[$y]->id;
        }

        $rules =  [
            'name' => 'required|min:4|max:50|unique:users',
            'empleado' => $empleados_disponibles,
            'email' => 'required|email|max:100|unique:users',
            'roles' => $roles_disponibles
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
            $rules['name'] = $rules['name'] . ',id,' . $userId; // debe ser unico, ignorando al userId
            $rules['email'] = $rules['email'] . ',id,' . $userId;
        }else{
            $rules['password'] = 'required|min:6|max:20';
        }
        return $rules; 
    }

    private function messages($isUpdate)
    {
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El campo nombre debe contener al menos 4 caracteres.',
            'name.max' => 'El campo nombre debe contener 50 caracteres como máximo.',
            'name.unique' => 'El nombre ya está en uso.',
            'empleado.required' => 'El campo empleado es obligatorio.',
            'empleado.in' => 'Datos invalidos para el campo empleado.',
            'email.required' => 'El campo e-mail es obligatorio.',
            'email.max' => 'El campo e-mail debe contener 100 caracteres como máximo.',
            'email.unique' => 'El e-mail ya está en uso.',
            'email.email' => 'El campo e-mail no corresponde con una dirección de e-mail válida.',
            'roles.required' => 'El campo roles es obligatorio.',
            'roles.in' => 'Datos invalidos para el campo roles.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }else{
            $messages['password.required'] = 'El campo contraseña es obligatorio.';
            $messages['password.min'] = 'El campo contraseña debe contener al menos 6 caracteres.';
            $messages['password.max'] = 'El campo contraseña debe contener 20 caracteres como máximo.';
        }

        return $messages; 
    }
}
