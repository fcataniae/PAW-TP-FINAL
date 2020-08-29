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
			selecteds: {!! collect(old("roles",[])) !!},
			all: {!! collect($roles) !!},
			submitName: 'roles[]',
			label: 'Roles'
		};
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
		<form action="{{ route('in.users.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="usuario">
				<div class="group size-6 sangria required">
					<label>Nombre: </label>
					<input type="text" id="name" name="name" value="{{ old('name') }}" class="input size-6" autocomplete="off">

				</div>
				<div class="group size-5 sangria required">
					<label>Empleado: </label>
					<input type="text" id="empleado" name="empleado" value="{{ old('empleado') }}" list="listaEmpleado" class="input size-6">
					<datalist id="listaEmpleado">
					   	@foreach($empleados as $empleado)
						    <option value="{{$empleado->id}}">{{$empleado->nombre . " " . $empleado->apellido}}</option>
						@endforeach
					</datalist>
				</div>
				<div class="group size-6 sangria required">
					<label>E-mail: </label>
					<input type="email" id="email" name="email" value="{{ old('email') }}" class="input size-8" autocomplete="off">

				</div>
				<div class="group size-5 sangria required">
					<label>Contraseña: </label>
					<input type="password" id="password" name="password" class="input size-4" autocomplete="off">

				</div>
				<div id="rolesSel" class="group size-12 sangria required">
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