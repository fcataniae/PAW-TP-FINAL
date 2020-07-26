@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/multiselect.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/multiselect.js')}}"></script>
	<script>
		var preSelected = {
			multiselection: 'permisosSel',
			selecteds: {!! collect(old("permisos",[])) !!},
			all: {!! collect($permisos) !!},
			submitName: 'permisos[]',
			label: 'Permisos'
		};
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<p><strong>Registrar Rol</strong></p>
		<form action="{{ route('in.roles.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Rol">
				<div class="group size-12 sangria">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" class="input size-4" value="{{ old('nombre') }}" autocomplete="off">
				</div>
				<div class="group size-12 sangria">
					<label>Descripcion: </label>
					<textarea name="descripcion" id="descripcion" rows="5" class="textarea size-6" >{{ old('descripcion') }}</textarea>
				</div>
				<div id="permisosSel" class="group size-12 sangria">
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