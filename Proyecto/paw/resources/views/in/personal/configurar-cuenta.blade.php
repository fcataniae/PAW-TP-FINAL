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
		<p><strong>Datos Cuenta</strong></p>
		<form action="{{ route('in.users.actualizar.datoscuenta') }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="datos-cuenta">
				<legend>Datos de usuario</legend>
				<div class="group size-3 sangria">
					<label>Nombre de usuario: </label>
					<input type="text" id="nombre" name="nombre" value="{{ $usuario->name }}" class="input size-12" readonly>
				</div>
				<div class="group size-4 sangria">
					<label>E-mail: </label>
					<input type="text" id="email" name="email" value="{{ $usuario->email }}" class="input size-12" readonly>
				</div>
			</fieldset>
			<br>
			<fieldset name="cambiar-password">
				<legend>Datos de cuenta</legend>
				<div class="group size-12 sangria">
					<label>Contraseña actual: </label>
					<input type="password" id="password_actual" name="password_actual" class="input size-4" autocomplete="off">
				</div>
				<div class="group size-12 sangria">
					<label>Nueva contraseña: </label>
					<input type="password" id="password_nuevo" name="password_nuevo" class="input size-4" autocomplete="off">
				</div>
				<div class="group size-12 sangria">
					<label>Confirmar nueva contraseña: </label>
					<input type="password" id="password_confirmacion" name="password_confirmacion" class="input size-4" autocomplete="off">
				</div>
				<div align="center">
					<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul">
				</div>
			</fieldset>
			<br>
		</form>
	</section>
@endsection