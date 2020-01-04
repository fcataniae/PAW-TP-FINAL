@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var productosAll = '{!! $productos !!}';
		var detalles = null;
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
	<section class="main">
		@include('partials.alert-message')
		<div id="msjError"></div>
		
		<fieldset name="Buscador">
			<legend>Buscador</legend>
			<div class="group">
				<label for="buscar_por">Producto: </label>
				<input type="text" id="valor_a_buscar" name="valor_a_buscar" list="valor_a_buscar_data" class="input">
				<datalist id="valor_a_buscar_data"></datalist>
			</div>
			<button onClick="buscar()" class="button-table"><i class="fa fa-search" aria-hidden="true"></i></button>
			<br>
			<br>
			<div class="group">
				<label>Descripcion: </label>
				<input type="text" id="descripcion" class="input" readonly>
			</div>
			<div class="group">
				<label>Talle: </label>
				<input type="text" id="talle" class="input" readonly>
			</div>
			<div class="group">
				<label>Precio: </label>
				<input type="number" id="precio" id="precio" class="input" readonly>
			</div>
			<div class="group">
				<label>Stock: </label>
				<input type="number" id="stock" min="0" class="input" readonly>
			</div>
			<div class="group">
				<label>Cantidad: </label>
				<input type="number" id="cantidad" min="0" class="input">
			</div>
			<button onClick="agregarDetalle(true)" class="button-table"><i class="fa fa-plus" aria-hidden="true"></i></button>
		</fieldset>
		<br>
		<form action="{{ route('in.facturas.gestionar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Detalles">
				<legend>Detalles</legend>
				<!-- Tabla -->
			    <table id="tabla_detalles" border="1" class="table">
				    <!-- columnas de la tabla -->
				    <thead>
				        <tr>
				    	    <th>Genero</th>
				            <th>Categoria</th>
				            <th>Tipo</th>
				            <th>Producto</th>
				            <th>Talle</th>
				            <th>Precio ($)</th>
				            <th>Stock</th>
				            <th style="width:150px">Cantidad</th>
				            <th>Subtotal ($)</th>
				            <th style="width:100px">Acción</th>
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
				<input type="number" id="total" name="total" min="0" value="0" class="input" readonly>
			</fieldset>
			<br>
			<input type="submit" name="Crear" value="Crear" class="button btn-form btn-azul">
		</form>
	</section>
@endsection
