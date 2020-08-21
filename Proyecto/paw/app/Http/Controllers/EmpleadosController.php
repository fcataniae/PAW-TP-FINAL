<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direccion as Direccion;
use App\Empleado as Empleado;
use App\Telefono as Telefono;
use App\Role as Rol;
use App\Tipo_Documento as Tipo_Documento;
use App\User as Usuario;
use Auth;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(Auth::user()->can('listar_empleado')){

            $permisoEditar = false;
            if(Auth::user()->can('modificar_empleado')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_empleado')){
                $permisoEliminar = true;
            }

            $columnas = array(
                array('headerName' => "Codigo", 'field' => "codigo"),
                array('headerName' => "Nombre", 'field' => "nombre"),
                array('headerName' => "Apellido", 'field' => "apellido"),
                array('headerName' => "CUIL", 'field' => "cuil"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Empleado::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.empleados.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.empleados.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->id, 
                                            'nombre' => $r->nombre, 
                                            'apellido' => $r->apellido,
                                            'cuil' => $r->cuil,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.empleado.index')
                    ->with('title','Empleados')
                    ->with('subtitle','Negocio')
                    ->with('columnas', $columnas)
                    ->with('registros',$registros);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function getAll(){
        
        if(Auth::user()->can('gestionar_reporte')){

            $empleados = Empleado::all();
            $array = array();
            foreach($empleados as $emp ){

                array_push($array,array(
                        'id' => $emp->id, 
                        'descripcion' => $emp->nro_documento.' - '.$emp->nombre.' '.$emp->apellido 
                    )
                );
            }
            return json_encode($array);
        }else{
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('crear_empleado')){
            $tiposDocumento = [];
            $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->where('descripcion','<>','CUIL')->get(); 
            $roles = [];
            $roles = Rol::orderBy('id','ASC')->where('estado', 'A')->get(); 
            return view('in.negocio.empleado.create')
                            ->with('ruta', 'in.empleados.listar')
                            ->with('title','Alta de empleado')
                            ->with('subtitle','Empleados')
                            ->with('tiposDocumento',$tiposDocumento)
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
        if(Auth::user()->can('crear_empleado')){
            $validarUser = $request->crear_usuario == "SI" ? true : false;
            $this->validate($request, $this->rules($request->_method == 'PUT', $validarUser), 
                                    $this->messages($request->_method == 'PUT', $validarUser));

            $empleado = new Empleado();
            $empleado->nombre = $request->nombre;
            $empleado->apellido = $request->apellido;
            $empleado->cuil = $request->cuil;
            $empleado->tipo_documento_id = $request->tipo_documento;
            $empleado->nro_documento = $request->nro_documento;
            if($empleado->save()){
                $direccion = new Direccion();
                $direccion->empleado_id = $empleado->id;
                $direccion->pais = $request->pais;
                $direccion->provincia = $request->provincia;
                $direccion->localidad = $request->localidad;
                $direccion->domicilio = $request->domicilio;
                $direccion->save();

                if($request->tel_fijo_caracteristica && $request->tel_fijo_numero){
                    $telFijo = new Telefono();
                    $telFijo->empleado_id = $empleado->id;
                    $telFijo->tipo_telefono = 'fijo';
                    $telFijo->nro_telefono = $request->tel_fijo_caracteristica . '-' . $request->tel_fijo_numero;
                    $telFijo->save();
                }

                if($request->tel_cel_caracteristica && $request->tel_cel_numero){
                    $celular = new Telefono();
                    $celular->empleado_id = $empleado->id;
                    $celular->tipo_telefono = 'celular';
                    $celular->nro_telefono = $request->tel_cel_caracteristica . '-' . $request->tel_cel_numero;
                    $celular->save();
                }
                if($validarUser){
                    $usuario = new Usuario();
                    $usuario->name = $request->name;
                    $usuario->empleado_id = $empleado->id;
                    $usuario->email = $request->email;
                    $usuario->password = bcrypt($request->password); // se encripta la contraseña
                    $usuario->save();
                }
               
            }
            return redirect()->route('in.empleados.listar')->with('success','Empleado ' . $empleado->nombre . " " . $empleado->apellido . ' agregado.');
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
        if(Auth::user()->can('modificar_empleado')){
            $empleado = Empleado::find($id);
            $tiposDocumento = [];
            $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->where('descripcion','<>','CUIL')->get(); 
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
            $json_ld =  $this->getJSONLdForEmpleado($empleado);
            return view('in.negocio.empleado.edit')
                        ->with('ruta', 'in.empleados.listar')
                        ->with('title','Modificación de empleado')
                        ->with('subtitle','Empleados')
                        ->with('empleado',$empleado)
                        ->with('telFijo',$telFijo)
                        ->with('celular',$celular)
                        ->with('tiposDocumento',$tiposDocumento)
                        ->with('json_ld', $json_ld);
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
        if(Auth::user()->can('modificar_empleado')){
            $validarUser = $request->crear_usuario == "SI" ? true : false;
            $this->validate($request, $this->rules($request->_method == 'PUT', $validarUser), 
                                    $this->messages($request->_method == 'PUT', $validarUser));
            
            $empleado = Empleado::find($id);
            $empleado->nombre = $request->nombre;
            $empleado->apellido = $request->apellido;
            $empleado->cuil = $request->cuil;
            $empleado->tipo_documento_id = $request->tipo_documento;
            $empleado->nro_documento = $request->nro_documento;
            $empleado->estado =  $request->estado;
            if($empleado->save()){
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
            }
            return redirect()->route('in.empleados.listar')->with('success','Empleado ' . $empleado->nombre . " " . $empleado->apellido . ' modificado.');
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
        if(Auth::user()->can('eliminar_empleado')){
            $empleado = Empleado::find($id);
            $empleado->delete();
            return redirect()->route('in.empleados.listar')->with('success', 'Empleado ' . $empleado->nombre . " " . $empleado->apellido . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate, $validarUser)
    {   
        $tiposDocumento = [];
        $tiposDocumento = Tipo_Documento::orderBy('id','ASC')->where('estado', 'A')->where('descripcion','<>','CUIL')->get(); 

        $tiposDocumento_rules = 'required|in:'.$tiposDocumento[0]->id;
        for ($i = 1; $i < sizeof($tiposDocumento); $i++) {
            $tiposDocumento_rules = $tiposDocumento_rules.','.$tiposDocumento[$i]->id;
        }

        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'tipo_documento' => $tiposDocumento_rules,
            'nro_documento' => 'required|min:3|max:20',
            'cuil' => 'required|min:3|max:20',
            'pais' => 'required',
            'provincia' => 'required',
            'localidad' => 'required',
            'domicilio' => 'required'
        ];

        if($validarUser){
             //Se traen los roles y personas disponibles para hacer las validaciones.
            if (Auth::user()->hasRole('super_usuario')) {
                $roles = Rol::where('estado', 'A')->get();
            } else {
                $roles = Rol::where('estado', 'A')->where('name','<>','super_usuario')->get();
            }

            $roles_rules = 'required|array|in:'.$roles[0]->id;
            for ($x = 1; $x < sizeof($roles); $x++) {
                $roles_rules = $roles_rules.','.$roles[$x]->id;
            }
            $rules['name'] = 'required|min:4|max:50|unique:users';
            $rules['email'] = 'required|email|max:100|unique:users';
            $rules['password'] = 'required|min:6|max:20';
            $rules['roles'] = $roles_rules;
        }

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
        }

      return $rules;
    }

    private function messages($isUpdate, $validarUser)
    {
      $messages = [
            'nombre.required' => 'El campo nombre del empleado es obligatorio.',
            'apellido.required' => 'El campo apellido del empleado es obligatorio.',
            'tipo_documento.required' => 'El campo tipo de documento es obligatorio.',
            'tipo_documento.in' => 'Datos invalidos para el campo tipo de documento.',
            'nro_documento.required' => 'El campo nro de documento es obligatorio.',
            'nro_documento.min' => 'El campo nro de documento debe contener al menos 3 caracteres.',
            'nro_documento.max' => 'El campo nro de documento debe contener 20 caracteres como máximo.',
            'cuil.required' => 'El campo cuil es obligatorio.',
            'cuil.min' => 'El campo cuil debe contener al menos 3 caracteres.',
            'cuil.max' => 'El campo cuil debe contener 20 caracteres como máximo.',
            'pais.required' => 'El campo pais es obligatorio.',
            'provincia.required' => 'El campo provincia es obligatorio.',
            'localidad.required' => 'El campo localidad es obligatorio.',
            'domicilio.required' => 'El campo domicilio es obligatorio.'
        ];
        if($validarUser){
            $messages['name.required'] = 'El campo nombre de usuario es obligatorio.';
            $messages['name.min'] = 'El campo nombre de usuario debe contener al menos 4 caracteres.';
            $messages['name.max'] = 'El campo nombre de usuario debe contener 50 caracteres como máximo.';
            $messages['name.unique'] = 'El nombre de usuario ya está en uso.';
            $messages['email.required'] = 'El campo e-mail es obligatorio.';
            $messages['email.max'] = 'El campo e-mail debe contener 100 caracteres como máximo.';
            $messages['email.unique'] = 'El e-mail ya está en uso.';
            $messages['email.email'] = 'El campo e-mail no corresponde con una dirección de e-mail válida.';
            $messages['password.required'] = 'El campo contraseña es obligatorio.';
            $messages['password.min'] = 'El campo contraseña debe contener al menos 6 caracteres.';
            $messages['password.max'] = 'El campo contraseña debe contener 20 caracteres como máximo.';
            $messages['roles.required'] = 'El campo roles es obligatorio.';
            $messages['roles.in'] = 'Datos invalidos para el campo roles.';
        }

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

      return $messages;
    }

    public function getJSONLdForEmpleado($empleado){

        $direccion = $empleado->direcciones[0];
        $jobTitle = '';
        foreach( $empleado->users[0]->roles as $rol){
            $jobTitle = $jobTitle.$rol->description.' ,';
        }
        $direc = array(
            '@type' => 'PostalAddress',
            'addressLocality' => $direccion->localidad,
            'addressRegion' => $direccion->provincia,
            'streetAddress' => $direccion->domicilio 
        );  
        $json_ld = array(
            '@context' => 'https://schema.org/',
            '@type' => 'Person',
            'adress' => $direc,
            'email' => $empleado->users[0]->email,
            'jobTitle' => $jobTitle,
            'name' => $empleado->nombre.' '.$empleado->apellido,
            'telephone' => $empleado->telefonos[0]->nro_telefono,
            'image' => $empleado->users[0]->imagen

        );

        return json_encode($json_ld, JSON_UNESCAPED_SLASHES);
    }
}
