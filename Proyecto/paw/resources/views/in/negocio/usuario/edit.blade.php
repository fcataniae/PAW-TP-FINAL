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
			multiselection: 'rolesSel',
			selecteds: {!! collect($my_roles) !!},
			all: {!! collect($roles) !!},
			submitName: 'roles[]',
			label: 'Roles'
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
		<form action="{{ route('in.users.actualizar', [$usuario->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="usuario">
				<div class="group size-6 sangria">
					<label>Nombre: </label>
					<input type="text" id="name" name="name" value="{{ $usuario->name }}" class="input size-6" autocomplete="off">

				</div>
				<div class="group size-5 sangria">
					<label>Empleado: </label>
					<input type="text" id="empleado" name="empleado" list="listaEmpleado" value="{{ $usuario->empleado_id }}" class="input size-6">
					<datalist id="listaEmpleado">
					   	@foreach($empleados as $empleado)
						    <option value="{{$empleado->id}}">{{$empleado->nombre . " " . $empleado->apellido}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-6 sangria">
					<label>E-mail: </label>
					<input type="email" id="email" name="email" value="{{ $usuario->email }}" class="input size-8" autocomplete="off">

				</div>
				<div class="group size-5 sangria">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($usuario->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($usuario->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
				<div id="rolesSel" class="group size-12 sangria">
				</div> 
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Restablecer" value="Restablecer" class="button btn-form btn-gris">
				<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul">
			</div>
		</form>
	</section>
@endsection