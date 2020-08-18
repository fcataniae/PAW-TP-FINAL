<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto as Producto;
use App\Talle as Talle;
use App\Tipo as Tipo;
use App\Stock_log;
use Auth;
use DateTime;
use Validator;

class ProductosController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('listar_producto')){
            $permisoEditar = false;
            if(Auth::user()->can('modificar_producto')){
                $permisoEditar = true;
            }

            $permisoEliminar = false;
            if(Auth::user()->can('eliminar_producto')){
                $permisoEliminar = true;
            }

            $columnas = array(
                array('headerName' => "Codigo", 'field' => "codigo"),
                array('headerName' => "Descripcion", 'field' => "descripcion"),
                array('headerName' => "Stock", 'field' => "stock"),
                array('headerName' => "Precio de venta ($)", 'field' => "precio_venta"),
                array('headerName' => "Estado", 'field' => "estado")
            );
            if($permisoEditar || $permisoEliminar){
              array_push($columnas,array('headerName' => "Accion", 'field' => "accion", 'width' => "100px"));
            }
            $columnas = json_encode($columnas);

            $registros = Producto::orderBy('id','ASC')->get();
            $array = array();
            $contador = 1;
            foreach($registros as $r ){
                $estado = "Inactivo";
                if($r->estado == "A"){
                    $estado = "Activo";
                }

                $action = array();
                if($permisoEditar){
                    $action['update'] = route('in.productos.editar', ['id' => $r->id]);
                }
                if($permisoEliminar){
                    $action['delete'] = route('in.productos.eliminar', ['id' => $r->id]);
                }

                array_push($array,array(
                        'id' =>  $contador,
                        'dataJson' => array('codigo' => $r->codigo, 
                                            'descripcion' => $r->descripcion,
                                            'stock' => $r->stock,
                                            'precio_venta' => $r->precio_venta,
                                            'estado' => $estado),
                        'action' => $action
                    )
                );
                $contador++;
            }
            $registros = json_encode($array);

            return view('in.negocio.producto.index')
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
        if(Auth::user()->can('crear_producto')){
            $tipos = [];
            $tipos = Tipo::orderBy('id','ASC')->where('estado', 'A')->get();
            $talles = [];
            $talles = Talle::orderBy('id','ASC')->where('estado', 'A')->get();

            return view('in.negocio.producto.create')
                    ->with('tipos',$tipos)
                    ->with('talles',$talles);
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
        if(Auth::user()->can('crear_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT', null), 
                                    $this->messages($request->_method == 'PUT'));

            // if($request->precio_costo >= $request->precio_venta){
            //     return redirect()->back()->withErrors('El precio de venta no puede ser menor o igual al precio de costo');
            // }

            $producto = new Producto();
            $producto->codigo = $request->codigo;
            $producto->descripcion = $request->descripcion;
            $producto->tipo_id = $request->tipo;
            $producto->talle_id = $request->talle;
            $producto->precio_costo = $request->precio_costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->stock = $request->stock;
            $producto->save();
            return redirect()->route('in.productos.listar')->with('success','Producto ' . $producto->descripcion . ' agregado.');
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
    public function updateStock($id,$nuevoStock,$comentario,$user)
    {
        $producto = Producto::find($id);

        $stocklog = new Stock_log();
        $stocklog->comentario_usuario = $comentario;
        $stocklog->stock_anterior = $producto->stock;
        $stocklog->stock_nuevo = $nuevoStock;
        $stocklog->id_producto = $id;
        $stocklog->usuario_modificacion = $user;
        $stocklog->fecha_creacion = new DateTime();
        if($stocklog->save()){
          $producto->stock = $nuevoStock;
          if($producto->save()){
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }
    }

      /**
       * Display the specified resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function showAll()
      {

          $productos = Producto::all();

          $columnas = array(
            array('headerName' => "Codigo", 'field' => "codigo"),
            array('headerName' => "Descripcion", 'field' => "descripcion"),
            array('headerName' => "Stock", 'field' => "stock"),
            array('headerName' => "Talle", 'field' => "talle_id"),
            array('headerName' => "Tipo", 'field' => "tipo_id"),
            array('headerName' => "Categoria", 'field' => "categoria")#,
           # array('headerName' => "Accion", 'field' => "accion", 'width' => "100px")
          );  

          $array =array();
          foreach($productos as $producto ){
            $estado = "Inactivo";
            if($producto->estado == "A"){
                $estado = "Activo";
            }
           # $action = array();
           # $action['update'] = route('in.inventario.reposicion', ['id' => $producto->id]);

            array_push($array,array(
                    'id' =>   $producto->id,
                    'dataJson' => array('codigo' =>  $producto->codigo, 
                                        'descripcion' =>  $producto->descripcion,
                                        'stock' =>  $producto->stock,
                                        'talle_id'=> $producto->talle->descripcion,
                                        'tipo_id' => $producto->tipo->descripcion,
                                        'categoria' => $producto->tipo->categoria->descripcion
                                    )#,
                #    'action' => $action
                )
            );
          }
          $data = array(
              'columnas' => $columnas,
              'registros' => $array
          );
          return $data;
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('modificar_producto')){
            $producto = Producto::find($id);
            $tipos = [];
            $tipos = Tipo::orderBy('id','ASC')->where('estado', 'A')->get();
            $talles = [];
            $talles = Talle::orderBy('id','ASC')->where('estado', 'A')->get();

            $json_ld = $this->getJSONLdForProducto($producto);
            return view('in.negocio.producto.edit')
                    ->with('producto',$producto)
                    ->with('tipos',$tipos)
                    ->with('talles',$talles)
                    ->with('json_ld', $json_ld);
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    public function findById($id)
    {
        $producto = Producto::find($id);
        $array  = array(    'id' =>  $producto->id,
                            'descripcion' => $producto->descripcion,
                            'stock' => $producto->stock,
                            'precio_venta' => $producto->precio_venta,
                            'talle'=> $producto->talle->descripcion,
                            'tipo' => $producto->tipo->descripcion,
                            'categoria' => $producto->tipo->categoria->descripcion,
                            'genero' => $producto->tipo->categoria->genero->descripcion);

        return json_encode($array);
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
        if(Auth::user()->can('modificar_producto')){
            $this->validate($request, $this->rules($request->_method == 'PUT', $id), 
                                    $this->messages($request->_method == 'PUT'));

            $producto = Producto::find($id);
            $producto->codigo = $request->codigo;
            $producto->descripcion = $request->descripcion;
            $producto->tipo_id = $request->tipo;
            $producto->talle_id = $request->talle;
            $producto->precio_costo = $request->precio_costo;
            $producto->precio_venta = $request->precio_venta;
            $producto->stock = $request->stock;
            $producto->estado = $request->estado;
            $producto->save();
            return redirect()->route('in.productos.listar')->with('success','Producto ' . $producto->descripcion . ' modificado.');
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
        if(Auth::user()->can('eliminar_producto')){
            $producto = Producto::find($id);
            $producto->delete();
            return redirect()->route('in.productos.listar')->with('success', 'Producto ' . $producto->descripcion . ' eliminado.');
        }else{
            return redirect()->route('in.sinpermisos.sinpermisos');
        }
    }

    private function rules($isUpdate, $producto)
    {
        Validator::extend('greater_than', function($attribute, $value, $parameters){
            $other = $parameters[0];
            return isset($other) and intval($value) > intval($other);
        });

        $tipos = [];
        $tipos = Tipo::where('estado', 'A')->get();
        $tipos_rules = 'required|in:'.$tipos[0]->id;
        for ($x = 1; $x < sizeof($tipos); $x++) {
            $tipos_rules = $tipos_rules.','.$tipos[$x]->id;
        }

        $talles = [];
        $talles = Talle::where('estado', 'A')->get();
        $talles_rules = 'required|in:'.$talles[0]->id;
        for ($x = 1; $x < sizeof($talles); $x++) {
            $talles_rules = $talles_rules.','.$talles[$x]->id;
        }

        $rules = [
            'codigo' => 'required|min:4|max:15|unique:productos',
            'descripcion' => 'required|min:2|max:75',
            'tipo' => $tipos_rules,
            'talle' => $talles_rules,
            'precio_costo' => 'required|min:0',
            'precio_venta' => 'required|min:0|greater_than:precio_costo',
            'stock' => 'required|min:0'
        ];

        if($isUpdate){
            $rules['estado'] = 'required|in:A,I';
            $rules['codigo'] = $rules['codigo'] . ',id,' . $producto; // debe ser unico, ignorando al producto actual
        }

        return $rules;
    }

    private function messages($isUpdate)
    {
        $messages = [
            'codigo.required' => 'El campo codigo es obligatorio.',
            'codigo.min' => 'El campo codigo debe contener al menos 4 caracteres.',
            'codigo.max' => 'El campo codigo debe contener 15 caracteres como máximo.',
            'descripcion.required' => 'El campo descripcion es obligatorio.',
            'descripcion.min' => 'El campo descripcion debe contener al menos 2 caracteres.',
            'descripcion.max' => 'El campo descripcion debe contener 75 caracteres como máximo.',
            'tipo.required' => 'El campo tipo es obligatorio.',
            'tipo.in' => 'Datos invalidos para el campo tipo.',
            'talle.required' => 'El campo talle es obligatorio.',
            'talle.in' => 'Datos invalidos para el campo talle.',
            'precio_costo.required' => 'El campo precio de costo es obligatorio.',
            'precio_costo.min' => 'El campo precio de costo no puede ser menor a 0.',
            'precio_venta.required' => 'El campo precio de venta es obligatorio.',
            'precio_venta.min' => 'El campo precio de venta no puede ser menor a 0.',
            'precio_venta.greater_than' => 'El precio de venta no puede ser menor o igual al precio de costo.',
            'stock.required' => 'El campo stock es obligatorio.',
            'stock.min' => 'El campo cantidad no puede ser menor a 0.'
        ];

        if($isUpdate){
            $messages['estado.required'] = 'El campo estado es requerido.';
            $messages['estado.in'] = 'Datos invalidos para el campo estado.';
        }

        return $messages;
    }

    public function getJSONLdForProducto($producto){

        $json_ld = array(
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $producto->codigo,
            'description' => $producto->description,
            'brand' => array(
                    '@type'=> 'Thing',
                    'name' => 'Brand name'
            ),
            'offers' => array(
                '@type' => 'Offer',
                'priceCurrency' => 'ARS',
                'price' => $producto->precio_venta,
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => 'http://schema.org/InStock',
                'seller' => array(
                    '@type' => 'Organization',
                    'name' => 'Out Organization'
                )
            )
        );

        return json_encode($json_ld, JSON_UNESCAPED_SLASHES);
    }
}
