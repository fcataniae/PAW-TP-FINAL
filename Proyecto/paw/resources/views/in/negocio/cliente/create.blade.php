@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
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
		<form action="{{ route('in.clientes.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="cliente">
				<div class="group size-6 sangria required">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre"  value="{{ old('nombre') }}" class="input size-5" autocomplete="off">
				</div>
				<div class="group size-5 sangria required">
					<label>Apellido: </label>
					<input type="text" id="apellido" name="apellido"  value="{{ old('apellido') }}" class="input size-6" autocomplete="off">
				</div>
				<div class="group-inline size-6 sangria required">
					<label>Documento: </label>
					<br>
					<select id="tipo_documento" name="tipo_documento"  value="{{ old('tipo_documento') }}" class="input">
					@foreach($tiposDocumento as $tipo)
					    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
					@endforeach
					</select>
					<input type="number" id="nro_documento" name="nro_documento"  value="{{ old('nro_documento') }}" min="0" class="input size-3" autocomplete="off">
				</div>
				<div class="group size-5 sangria required">
					<label>E-mail: </label>
					<input type="email" id="email" name="email"  value="{{ old('email') }}" class="input size-7" autocomplete="off">
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