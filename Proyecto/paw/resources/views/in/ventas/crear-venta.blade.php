@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var productosAll = '{!! $productos !!}';
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
			<select id="buscar_por" name="buscar_por" onchange="opcionesValoresABuscar()">
			    <option id="1" value="CODIGO">CODIGO: </option>
			    <option id="2" value="ID">DESCRIPCION: </option>
			</select>
			<input type="text" id="valor_a_buscar" name="valor_a_buscar" list="valor_a_buscar_data">
			<datalist id="valor_a_buscar_data"></datalist>
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
			<button onClick="agregarDetalle(true)"><i class="fa fa-plus" aria-hidden="true"></i></button>
		</fieldset>
		<br>
		<form action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
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
				    <tbody></tbody>
				</table>
			</fieldset>
			<br>
			<fieldset name="Total">
				<legend>Total</legend>
				<label for="total">Total ($): </label>
				<input type="number" id="total" name="total" min="0" value="0" readonly>
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