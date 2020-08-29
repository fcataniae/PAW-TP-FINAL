<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forma_Pago as Forma_Pago;
use Auth;

class FormaPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('listar_forma_pago')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_forma_pago')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_forma_pago')){
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

            $registros = Forma_Pago::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.forma_pago.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.forma_pago.eliminar', ['id' => $r->id]);
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

            return view('in.negocio.forma_pago.index')
                    ->with('ruta', 'in.forma_pago.listar')
                    ->with('title','Tabla de formas de pago')
                    ->with('subtitle','Formas de pago')
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
        if(Auth::user()->can('crear_forma_pago')){
            return view('in.negocio.forma_pago.create')
                ->with('ruta', 'in.forma_pago.listar')
                ->with('title','Alta de forma de pago')
                ->with('subtitle','Formas de pago');
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
        if(Auth::user()->can('crear_forma_pago')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $formapago = new Forma_Pago();
            $formapago->descripcion = $request->descripcion;
            $formapago->save();
            return redirect()->route('in.forma_pago.listar')->with('success','Forma de pago ' . $formapago->descripcion . ' agregado.');
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
        if(Auth::user()->can('modificar_forma_pago')){
            $formapago = Forma_Pago::find($id);
            return view('in.negocio.forma_pago.edit')
                    ->with('ruta', 'in.forma_pago.listar')
                    ->with('title','Modificación de forma de pago')
                    ->with('subtitle','Formas de pago')
                    ->with('formapago', $formapago);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }


    public function getAll(){
        
        if(Auth::user()->can('gestionar_reporte')){

             return json_encode(Forma_Pago::all());
        }else{
            return response()->json(['error' => 'Unauthenticated.'], 401);
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
        if(Auth::user()->can('modificar_forma_pago')){

            $this->validate($request, $this->rules($request->_method == 'PUT'), 
                                    $this->messages($request->_method == 'PUT'));

            $formapago = Forma_Pago::find($id);
            $formapago->descripcion = $request->descripcion;
            $formapago->estado = $request->estado;
            $formapago->save();
            return redirect()->route('in.forma_pago.listar')->with('success','Forma de pago ' . $formapago->descripcion . ' modificada.');
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
        if(Auth::user()->can('eliminar_forma_pago')){
            $formapago = Forma_Pago::find($id);
            $formapago->delete();
            return redirect()->route('in.forma_pago.listar')->with('success', 'Forma de pago ' . $formapago->descripcion . ' eliminado.');
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
