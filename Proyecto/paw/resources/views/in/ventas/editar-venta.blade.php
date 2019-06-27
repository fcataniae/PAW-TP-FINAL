@extends('layouts.main')

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	
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
			<input type="text" name="descripcion" readonly>
			<label>Talle: </label>
			<input type="text" name="talle" readonly>
			<label>Precio: </label>
			<input type="number" id="precio" name="precio" readonly>
			<label>Stock: </label>
			<input type="number" name="stock" min="0" readonly>
			<label>Cantidad: </label>
			<input type="number" id="cantidad" name="cantidad" min="0">
			<button onClick="agregarDetalle()"><i class="fa fa-plus" aria-hidden="true"></i></i></button>
		</fieldset>
		<br>
		<form action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Buscador">
				<legend>Factura</legend>
				<label>Nro Factura: </label>
				<input type="text" name="id" value="{{ $factura->id }}" readonly>
			</fieldset>
			<br>
			<fieldset name="Detalles">
				<legend>Detalles</legend>
				<!-- Tabla -->
			    <table  border="1">
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
			            <tr>
			            	<td>{{$detalle->producto->tipo->categoria->genero->descripcion}}</td>
			              	<td>{{$detalle->producto->tipo->categoria->descripcion}}</td>
			              	<td>{{$detalle->producto->tipo->descripcion}}</td>
			              	<td>{{$detalle->producto->descripcion}}</td>
			              	<td>{{$detalle->producto->talle->descripcion}}</td>
			              	<td>{{$detalle->producto->precio_venta}}</td>
			              	<td>{{$detalle->producto->stock}}</td>
			              	<td><input type="text" name="id" value="{{ $detalle->cantidad }}" readonly></td>
			            	<td>{{$detalle->cantidad * $detalle->producto->precio_venta}}</td>
			            	<td>
				                @if(true)
				                  <a href="{{ route('in.facturas.actualizar')}}" class="btn btn-primary"><span class="fa fa-pencil" aria-hidden="true"></span></a>
				                @endif
				                @if(true)
				                 
				                    <a href="" class="btn btn-danger" data-toggle="modal" data-target="#delSpk" data-title="Eliminar Conocimiento Idioma"
				                      data-message="¿Seguro que quiere eliminar?"><span class=" fa fa-trash-o" aria-hidden="true"></span></a>
				                  
				                @endif
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
				<input type="number" id="total" name="total" min="0" readonly value="0">
			</fieldset>
			<br>
			<input type="submit" name="Crear" value="Crear">
		</form>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
