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
		<form action="{{ route('in.clientes.actualizar', [$cliente->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="cliente">
				<div class="group size-4 sangria required">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" value="{{ $cliente->nombre }}" class="input size-8" autocomplete="off">
				</div>
				<div class="group size-4 sangria required">
					<label>Apellido: </label>
					<input type="text" id="apellido" name="apellido" value="{{ $cliente->apellido }}" class="input size-8" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($cliente->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($cliente->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
				<div class="group-inline size-4 sangria required">
					<label>Documento: </label>
					<br>
					<select id="tipo_documento" name="tipo_documento" class="input">
					@foreach($tiposDocumento as $tipo)
					    <option value="{{$tipo->id}}" @if($cliente->tipo_documento_id == $tipo->id) selected @endif>{{$tipo->descripcion}}</option>
					@endforeach
					</select>
					<input type="number" id="nro_documento" name="nro_documento" min="0" value="{{ $cliente->nro_documento }}" class="input size-5" autocomplete="off">
				</div>
				<div class="group size-5 sangria required">
					<label>E-mail: </label>
					<input type="email" id="email" name="email" value="{{ $cliente->email }}" class="input size-7" autocomplete="off">
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