<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto as Producto;
use Auth;
use DateTime;
use App\Stock_log;

class ProductosController extends Controller
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
                if($r->estado = "A"){
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
                        'dataJson' => array('codigo' => $r->id, 
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
        //
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

          $array =array();
          foreach($productos as $producto ){
            array_push($array,array(    'id' =>  $producto->id,
                      'descripcion' => $producto->descripcion,
                      'stock' => $producto->stock,
                      'precio_costo' => $producto->precio_costo,
                      'estado' => $producto->estado,
                      'codigo' => $producto->codigo,
                      'precio_venta' => $producto->precio_venta,
                      'talle_id'=> $producto->talle->descripcion,
                      'tipo_id' => $producto->tipo->descripcion,
                      'categoria' => $producto->tipo->categoria->descripcion)
                      );
          }

          return json_encode($array);
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
        //
    }
}
