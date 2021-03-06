@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script type="application/ld+json">
		{!! $json_ld !!} 
	</script>
	<script type="text/javascript">
		window.onbeforeunload = function(e) {
		  return '';
		};
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		@include('partials.menulayout')
		<form action="{{ route('in.productos.actualizar', [$producto->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="producto-descripcion">
				<div class="group size-3 sangria required">
					<label>Codigo: </label>
					<input type="text" name="codigo" id="codigo" value="{{ $producto->codigo }}" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-5 sangria required">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" value="{{ $producto->descripcion }}" class="input size-10"  autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($producto->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($producto->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
				<div class="group size-3 sangria required">
					<label>Tipo: </label>
					<input type="text" id="tipo" name="tipo" list="listaTipo" value="{{ $producto->tipo_id }}" class="input size-6" autocomplete="off">
					<datalist id="listaTipo">
					   	@foreach($tipos as $tipo)
						    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-3 sangria required">
					<label>Talle: </label>
					<input type="text" id="talle" name="talle" list="listaTalle" value="{{ $producto->talle_id }}" class="input size-6" autocomplete="off">
					<datalist id="listaTalle">
					   	@foreach($talles as $talle)
						    <option value="{{$talle->id}}">{{$talle->descripcion}}</option>
						@endforeach
					</datalist>
				</div>
			</fieldset>
			<br>
			<fieldset name="producto-valores">
				<div class="group size-3 sangria required">
					<label>Precio de costo ($): </label>
					<input type="number" name="precio_costo" id="precio_costo" min="0" value="{{ $producto->precio_costo }}" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Precio de venta ($): </label>
					<input type="number" name="precio_venta" id="precio_venta" min="0" value="{{ $producto->precio_venta }}" class="input size-6"  autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Cantidad: </label>
					<input type="number" name="stock" id="stock" min="0" value="{{ $producto->stock }}" class="input size-6"  autocomplete="off">
				</div>
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Restablecer" value="Restablecer" class="button btn-form btn-gris">
				<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul" onclick="window.onbeforeunload = null">
			</div>
		</form>
	</section>
@endsection