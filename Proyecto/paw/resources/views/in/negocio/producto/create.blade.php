@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<p><strong>Registrar Producto</strong></p>
		<form action="{{ route('in.productos.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="producto-descripcion">
				<div class="group size-3 sangria">
					<label>Codigo: </label>
					<input type="text" name="codigo" id="codigo" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-8 sangria">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Tipo: </label>
					<input type="text" id="tipo" name="tipo" list="listaTipo" class="input size-6" autocomplete="off">
					<datalist id="listaTipo">
					   	@foreach($tipos as $tipo)
						    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-3 sangria">
					<label>Talle: </label>
					<input type="text" id="talle" name="talle" list="listaTalle" class="input size-6" autocomplete="off">
					<datalist id="listaTalle">
					   	@foreach($talles as $talle)
						    <option value="{{$talle->id}}">{{$talle->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
			</fieldset>
			<br>
			<fieldset name="producto-valores">
				<div class="group size-3 sangria">
					<label>Precio de costo ($): </label>
					<input type="number" name="precio_costo" id="precio_costo" value="0" min="0" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Precio de venta ($): </label>
					<input type="number" name="precio_venta" id="precio_venta" value="0" min="0" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Cantidad: </label>
					<input type="number" name="stock" id="stock" value="0" min="0" class="input size-6"  autocomplete="off">
				</div>
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Borrar" value="Borrar" class="button btn-form btn-gris">
				<input type="submit" name="Crear" value="Crear" class="button btn-form btn-azul">
			</div>
		</form>
	</section>
@endsection