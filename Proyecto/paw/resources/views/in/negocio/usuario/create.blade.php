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
		<p><strong>Registrar Usuario</strong></p>
		<form action="{{ route('in.users.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="Usuario">
				<div class="group size-6 sangria">
					<label>Nombre: </label>
					<input type="text" id="name" name="name" class="input size-6" autocomplete="off">

				</div>
				<div class="group size-5 sangria">
					<label>Empleado: </label>
					<input type="text" id="empleado" name="empleado" list="listaEmpleado" class="input size-6">
					<datalist id="listaEmpleado">
					   	@foreach($empleados as $empleado)
						    <option value="{{$empleado->id}}">{{$empleado->nombre . " " . $empleado->apellido}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-6 sangria">
					<label>E-mail: </label>
					<input type="email" id="email" name="email" class="input size-8" autocomplete="off">

				</div>
				<div class="group size-5 sangria">
					<label>Contraseña: </label>
					<input type="password" id="password" name="password" class="input size-4" autocomplete="off">

				</div>
				<div class="group size-12 sangria">
					<label>Roles: </label>
					<select name="roles[]" multiple class="input size-4">
				    @foreach($roles as $rol)
					    <option value="{{$rol->id}}">{{$rol->display_name}}</option>
					@endforeach
				  	</select>
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