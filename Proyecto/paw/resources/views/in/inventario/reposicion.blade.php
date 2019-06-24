@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
@endsection
@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	@include('partials.nav-lateral-negocio')
  @include('partials.nav-lateral-inventario')
	@include('partials.nav-lateral-ventas')

	<section class="main">

		<p><strong>Reposicion de Stock</strong></p>
    <form class="form" action={{ route('in.inventario.update') }} method="post">
			<div class="form-group">
				<label for="descripcion">Descripcion del producto</label>
				<input  disabled id="descripcion" class="form-input" type="text" name="descripcion" value={{$data['descripcion']}}>
			</div>
			<div class="form-group">
				<label for="stock">Stock</label>
				<input id="stock" class="form-input" type="number" min={{$data['stock']}} pattern="^[0-9]+" name="stock" value={{$data['stock']}} required>
			</div>
			<div class="form-group">
				<label for="talle">Talle</label>
				<input disabled  id="talle" class="form-input" type="text" name="talle" value={{$data['talle']}}>
			</div>
			<div class="form-group">
				<label for="tipo">Tipo de producto</label>
				<input disabled  id="tipo" class="form-input" type="text" name="tipo" value={{$data['tipo']}}>
			</div>
			<div class="form-group">
				<label for="categoria">Categoria de producto</label>
				<input disabled  id="categoria" class="form-input" type="text" name="categoria" value={{$data['categoria']}}>
			</div>
			<div class="form-group">
				<label for="precio">Precio de venta</label>
				<input disabled id="precio" class="form-input" type="text" name="precio" value={{$data['precio_venta']}}>
			</div>

			<input class="form-submit" type="submit" name="" value="Actualizar stock">
		</form>
	</section>
@endsection
@section('body-footer')
	<address>Guerrero, Pedro</address>
	<address>Telefono: 11235687</address>
@endsection
