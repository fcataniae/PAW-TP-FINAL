@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
@endsection

@section('body-header')
	<h1 class="logo"><a href="#">Logo Tienda</a></h1>
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<p><strong>Registrar Permiso</strong></p>
		<form action="{{ route('in.permissions.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="permiso">
				<div class="group size-12 sangria">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" class="input size-4">

				</div>
				<div class="group size-12 sangria">
					<label>Descripcion: </label>
					<textarea name="descripcion" id="descripcion" rows="5" class="textarea size-6" ></textarea>
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