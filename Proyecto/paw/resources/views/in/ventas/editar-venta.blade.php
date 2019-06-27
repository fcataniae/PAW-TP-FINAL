@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var factura = '{!!$factura!!}';
		var detalles = '{!!$detalles!!}';
	</script>
	
@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
	@include('partials.nav-lateral-ventas')
	<section class="main">
		@include('partials.alert-message')
		<fieldset name="Buscador">
			<legend>Buscador</legend>
			<label for="buscar_por">Buscar por </label>
			<select id="buscar_por" name="buscar_por">
			    <option id="1" value="ID">ID: </option>
			    <option id="2" value="CODIGO">CODIGO: </option>
			</select>
			<input type="text" id="valor_a_buscar" name="valor_a_buscar">
			<button onClick="buscar()"><i class="fa fa-search" aria-hidden="true"></i></button>
			<br>
			<br>
			<label>Descripcion: </label>
			<input type="text" id="descripcion" readonly>
			<label>Talle: </label>
			<input type="text" id="talle" readonly>
			<label>Precio: </label>
			<input type="number" id="precio" id="precio" readonly>
			<label>Stock: </label>
			<input type="number" id="stock" min="0" readonly>
			<label>Cantidad: </label>
			<input type="number" id="cantidad" min="0">
			<button onClick="agregarDetalle(false)"><i class="fa fa-plus" aria-hidden="true"></i></button>
		</fieldset>
		<br>
		<form action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Buscador">
				<legend>Factura</legend>
				<label>Nro Factura: </label>
				<input type="text" id="nro_factura" name="nro_factura"  value="{{ $factura->id }}" readonly>
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Detalles</legend>
				<!-- Tabla -->
			    <table id="tabla_detalles" border="1">
				    <!-- columnas de la tabla -->
				    <thead>
				        <tr>
				    	    <th>Genero</th>
				            <th>Categoria</th>
				            <th>Tipo</th>
				            <th>Producto</th>
				            <th>Talle</th>
				            <th>Precio</th>
				            <th>Stock</th>
				            <th>Cantidad</th>
				            <th>Subtotal</th>
				            <th style="width:75px">Acción</th>
				        </tr>
				    </thead>
				    <!-- contenido de la tabla -->
				    <tbody>
			        	@foreach( $detalles as $detalle )
			            <tr id="nro_detalle_{{$detalle->id}}">
			            	<td id="genero_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->genero->descripcion}}</td>
			              	<td id="categoria_{{$detalle->id}}">{{$detalle->producto->tipo->categoria->descripcion}}</td>
			              	<td id="tipo_{{$detalle->id}}">{{$detalle->producto->tipo->descripcion}}</td>
			              	<td id="producto_{{$detalle->id}}">{{$detalle->producto->descripcion}}</td>
			              	<td id="talle_{{$detalle->id}}">{{$detalle->producto->talle->descripcion}}</td>
			              	<td id="precio_{{$detalle->id}}">{{$detalle->producto->precio_venta}}</td>
			              	<td id="stock_{{$detalle->id}}">{{$detalle->producto->stock}}</td>
			              	<td><input type="number" id="cantidad_{{$detalle->id}}" value="{{ $detalle->cantidad }}" min="0" readonly></td>
			            	<td id="subtotal_{{$detalle->id}}" name="subtotal">{{$detalle->cantidad * $detalle->producto->precio_venta}}</td>
			            	<td>
				                 <button id="editar_{{$detalle->id}}" type="button" onClick="editarDetalle({{$detalle->id}})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
				                 <button id="deshacer_{{$detalle->id}}" type="button" onClick="deshacerCambios({{$detalle->id}})" style="display:none;"><i class="fa fa-undo" aria-hidden="true"></i></button>
			                 	<button id="guardar_{{$detalle->id}}" type="button" onClick="guardarCambios({{$detalle->id}}, false)" style="display:none;"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
			                	<button id="eliminar_{{$detalle->id}}" type="button" onClick="eliminarDetalle({{$detalle->id}}, false)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				            </td>
			            </tr>
			        	@endforeach
			    	</tbody>
				</table>
			</fieldset>
			<br>
			<fieldset name="Total">
				<legend>Total</legend>
				<label for="total">Total ($): </label>
				<input type="number" id="total" name="total" min="0" value="{{$factura->importe}}" readonly>
			</fieldset>
			<br>
			<input type="submit" name="Anular" value="Anular">
			<input type="submit" name="Reservar" value="Reservar">
			<input type="submit" name="Continuar" value="Continuar">
		</form>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
