@extends('layouts.main')

@section('head-js')
	<meta name="csrf-token" content="{{{ csrf_token() }}}">
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ventas.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script>
		var productosAll = '{!! $productos !!}';
		var factura = null;
		var detalles = null;
	</script>

@endsection

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message') 	<!-- Errores del BACK -->
		<div id="msjError"></div> 			<!-- Errores en JavaScript -->
		@include('partials.menulayout')
		<form action="{{ route('in.facturas.gestionar')}}" method="POST" onsubmit="return enviar(event);">
			{{ csrf_field() }}
			<fieldset name="Detalles">
				<legend>Productos</legend>
				<div style="margin: 10px">
					<label for="buscar_por">Producto: </label>
					<input type="text" id="valor_a_buscar" name="valor_a_buscar" list="valor_a_buscar_data" class="input">
					<datalist id="valor_a_buscar_data"></datalist>
					<input type="button" id="agregar" onClick="agregarProducto()" name="Agregar" value="Agregar" class="button-table btn-azul">
				</div>
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
				            <th>Precio</th>
				            <th>Stock</th>
				            <th style="width:150px">Cantidad</th>
				            <th>Subtotal</th>
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
				<div align="right" style="margin-right: 10px">
					<label for="total">Total ($): </label>
					<input type="number" id="total" name="total" min="0" value="0" class="input" readonly>
				<div>
			</fieldset>
			<br>
			<input type="submit" id="submit" name="Crear" value="Crear" class="button btn-form btn-azul">
		</form>
	</section>
@endsection
