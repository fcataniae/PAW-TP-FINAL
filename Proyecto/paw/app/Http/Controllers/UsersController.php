<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direccion as Direccion;
use App\Empleado as Empleado;
use App\Telefono as Telefono;
use App\User as Usuario;
use App\Role as Rol;
use App\Tipo_Documento as Tipo_Documento;
use Auth;
use File;
use Hash;
use Log;

class UsersController extends Controller
{

    protected $controller;
    
    public function __construct(){
        $this->controller = new EmpleadosController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('listar_usuario')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_usuario')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_usuario')){
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
                if($r->estado == "A"){
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
                    ->with('ruta', 'in.users.listar')
                    ->with('title','Tabla de usuarios')
                    ->with('subtitle','Usuarios')
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
        if(Auth::user()->can('crear_usuario')){
            $empleados = [];
            $empleados = Empleado::orderBy('id','ASC')->where('estado', 'A')->get(); 
            $roles = [];
            $roles = Rol::orderBy('id','ASC')->where('estado', 'A')->get(); 
            return view('in.negocio.usuario.create')
                ->with('ruta', 'in.users.listar')
                ->with('title','Alta de usuario')
                ->with('subtitle','Usuarios')
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
        if(Auth::user()->can('crear_usuario')){
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
        if(Auth::user()->can('modificar_usuario')){
            $usuario = Usuario::find($id);

            $empleados = [];
            $empleados = Empleado::orderBy('id','ASC')->where('estado', 'A')->get(); 
            $roles = [];
            $roles = Rol::orderBy('id','ASC')->where('estado', 'A')->get(); 

            // necesito el array de los permisos q contiene (solo los id's)
            $my_roles = $usuario->roles->pluck('id')->toArray(); // pasa un objeto a un array
            return view('in.negocio.usuario.edit')
                    ->with('ruta', 'in.users.listar')
                    ->with('title','Modificación de usuario')
                    ->with('subtitle','Usuarios')
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
        if(Auth::user()->can('modificar_usuario')){
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
        if(Auth::user()->can('eliminar_usuario')){
            $usuario = Usuario::find($id);
            File::delete(public_path().'/img/usuarios/'.$usuario->imagen);
            $usuario->delete();
            return redirect()->route('in.users.listar')->with('success', 'Usuario ' . $usuario->name . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function getDatosPersonal(){
        $empleado = Empleado::find(Auth::user()->empleado_id);
        $tipoDocumento = Tipo_Documento::find($empleado->tipo_documento_id); 
        $telFijo = [];
        $celular = [];
        foreach ($empleado->telefonos as $telefono){
            switch ($telefono->tipo_telefono) {
                case "fijo":
                    $tel = explode("-",$telefono->nro_telefono);
                    $telFijo['area'] = $tel[0];
                    $telFijo['numero'] = $tel[1];
                    break;
                case "celular":
                    $cel = explode("-",$telefono->nro_telefono);
                    $celular['area'] = $cel[0];
                    $celular['numero'] = $cel[1];
                    break;
            }
        }
        $json_ld = $this->controller->getJSONLdForEmpleado($empleado);
        return view('in.personal.configurar-datos')
                    ->with('title','Datos personales')
                    ->with('subtitle','')
                    ->with('empleado',$empleado)
                    ->with('telFijo',$telFijo)
                    ->with('celular',$celular)
                    ->with('tipoDocumento',$tipoDocumento)
                    ->with('json_ld', $json_ld);
    }

    public function updateDatosPersonal(Request $request){
        $rules = [
            'pais' => 'required',
            'provincia' => 'required',
            'localidad' => 'required',
            'domicilio' => 'required'
        ];
        $messages = [
            'pais.required' => 'El campo pais es obligatorio.',
            'provincia.required' => 'El campo provincia es obligatorio.',
            'localidad.required' => 'El campo localidad es obligatorio.',
            'domicilio.required' => 'El campo domicilio es obligatorio.'
        ];
        $this->validate($request, $rules, $messages);
        
        $empleado = Empleado::find(Auth::user()->empleado_id);
        $direccion = $empleado->direcciones[0];
        $direccion->empleado_id = $empleado->id;
        $direccion->pais = $request->pais;
        $direccion->provincia = $request->provincia;
        $direccion->localidad = $request->localidad;
        $direccion->domicilio = $request->domicilio;
        $direccion->save();

        if($request->tel_fijo_caracteristica && $request->tel_fijo_numero){
            $telFijo = new Telefono();
            foreach ($empleado->telefonos as $telefono){
                if($telefono->tipo_telefono == "fijo"){
                    $telFijo = $telefono;
                    break;
                }
            }
            $telFijo->empleado_id = $empleado->id;
            $telFijo->tipo_telefono = 'fijo';
            $telFijo->nro_telefono = $request->tel_fijo_caracteristica . '-' . $request->tel_fijo_numero;
            $telFijo->save();
        }

        // no seteo telefono fijo borro si existe
        if(!isset($request->tel_fijo_caracteristica) && !isset($request->tel_fijo_numero )){
            $telFijo = new Telefono();
            foreach ($empleado->telefonos as $telefono){
                    if($telefono->tipo_telefono == "fijo"){
                        $telFijo = $telefono;
                        break;
                    }
                }
            $telFijo->delete();
        }

        if($request->tel_cel_caracteristica && $request->tel_cel_numero){
            $celular = new Telefono();
            foreach ($empleado->telefonos as $telefono){
                if($telefono->tipo_telefono == "celular"){
                    $celular = $telefono;
                    break;
                }
            }
            $celular->empleado_id = $empleado->id;
            $celular->tipo_telefono = 'celular';
            $celular->nro_telefono = $request->tel_cel_caracteristica . '-' . $request->tel_cel_numero;
            $celular->save();
        }

        // no seteo celular borro si existe
        if(!isset($request->tel_cel_caracteristica) && !isset($request->tel_cel_numero )){
            $celular = new Telefono();
            foreach ($empleado->telefonos as $telefono){
                if($telefono->tipo_telefono == "celular"){
                    $celular = $telefono;
                    break;
                }
            }
            $celular->delete();
        }
        return redirect()->route('in.users.edit.datospersonal')->with('success','Los datos personales se han modificado.');
    }

    public function getDatosCuenta(){
        $usuario = Auth::user();
        return view('in.personal.configurar-cuenta')
                    ->with('title','Datos de la cuenta')
                    ->with('subtitle','')
                    ->with('usuario',$usuario);
    }

    public function updateDatosCuenta(Request $request){
        
      if (Hash::check($request->password_actual, Auth::user()->password)) {
        if($request->password_nuevo == $request->password_confirmacion){
            $usuario = Auth::user();
            $usuario->password = bcrypt($request->password_nuevo);
            $usuario->save();
            return redirect()->route('in.users.edit.datoscuenta')->with('success','La contraseña se ha modificado.');
        }else{
            return redirect()->back()->withErrors("La contraseña nueva no coincide.");
        }
      }else {
        return redirect()->back()->withErrors("La contraseña actual no coincide.");
      }

    }

    public function updateImagenCuenta(Request $request){
        $rules = [
            'imagen_load' => 'image|mimes:jpg,jpeg,gif,png|max:500',
            'imagen_cambiada' => 'required|in:0,1'
        ];
        $messages = [
            'imagen_load.image' => 'El archivo debe ser una imagen.',
            'imagen_load.mimes' => 'La imagen debe ser jpg, jpeg, png o gif.',
            'imagen_load.max' => 'La imagen no debe pesar más de 500 kb.',
            'imagen_cambiada.in' => 'Datos invalidos.'
        ];
        $this->validate($request, $rules, $messages);

        $usuario = Auth::user();
        $imagenVieja = $usuario->imagen;
        $usuario = $this->updateImagen($imagenVieja, $usuario, $request);
        $usuario->save();
        return redirect()->route('in.users.edit.datoscuenta')->with('success','La imagen se ha modificado.');
    }

    private function updateImagen($imagenVieja, $usuario, $request){
        //Guarda la Imagen. Manipular Imagenes y no colisiones de nombres
        if ($request->imagen_load == null) {
            if ($request->imagen_cambiada == 1) {
                $usuario->imagen = null;
                File::delete(public_path().'/img/usuarios/'.$imagenVieja);
            }
        }else{
            if ($request->hasFile('imagen_load')) {
                File::delete(public_path().'/img/usuarios/'.$imagenVieja);
                $file = $request->file('imagen_load');
                $name = 'user_' . $usuario->id . '_image_' . time().'.'. $file->getClientOriginalExtension();
                $path = public_path(). '/img/usuarios/';
                $file->move($path, $name);
                $usuario->imagen = $name;
            }
        }
        return $usuario;
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
