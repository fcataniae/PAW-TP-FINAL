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
		<form action="{{ route('in.permissions.actualizar', [$permiso->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="permiso">
				<div class="group size-6 sangria required">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" value="{{ $permiso->display_name }}" class="input size-8" autocomplete="off">
				</div>
				<div class="group size-5 sangria required">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($permiso->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($permiso->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
				<div class="group size-12 sangria required">
					<label>Descripcion: </label>
					<textarea name="descripcion" id="descripcion" rows="5" class="textarea size-6">{{ $permiso->description }}</textarea>
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