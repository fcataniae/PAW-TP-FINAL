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
		<form action="{{ route('in.empleados.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="datos-personales">
				<legend>Datos personales</legend>
				<div class="group size-2 sangria required">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" class="input size-12" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Apellido: </label>
					<input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" class="input size-12" autocomplete="off">
				</div>
				<div class="group-inline size-3 sangria required">
					<label>Documento: </label>
					<br>
					<select id="tipo_documento" name="tipo_documento" value="{{ old('tipo_documento') }}" class="input">
					@foreach($tiposDocumento as $tipo)
					    <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
					@endforeach
					</select>
					<input type="number" id="nro_documento" name="nro_documento" value="{{ old('nro_documento') }}" min="0" class="input size-8" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>CUIL: </label>
					<input type="number" id="cuil" name="cuil" value="{{ old('cuil') }}" min="0" class="input size-10"  autocomplete="off">
				</div>
			</fieldset>
			<br>
			<fieldset name="datos-residencia">
				<legend>Datos de residencia</legend>
				<div class="group size-2 sangria required">
					<label>Pais: </label>
					<input type="text" id="pais" name="pais" value="{{ old('pais') }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Provincia: </label>
					<input type="text" id="provincia" name="provincia" value="{{ old('provincia') }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Localidad: </label>
					<input type="text" id="localidad" name="localidad" value="{{ old('localidad') }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Domicilio: </label>
					<input type="text" id="domicilio" name="domicilio" value="{{ old('domicilio') }}" class="input size-12" autocomplete="off">
				</div>
			</fieldset>
			<br>
			<fieldset name="datos-contacto">
				<legend>Datos de contacto</legend>
				<div class="group-inline size-5 sangria">
					<label>Teléfono (Fijo): </label>
					<br>
					<strong>( </strong>
					<input type="number" id="tel_fijo_caracteristica" name="tel_fijo_caracteristica" class="input size-2" autocomplete="off">
					 <strong> ) </strong>
					<input type="number" id="tel_fijo_numero" name="tel_fijo_numero" class="input size-4" autocomplete="off">
				</div>
				<div class="group-inline size-5 sangria">
					<label>Teléfono (Celular): </label>
					<br>
					<strong>( </strong>
					<input type="number" id="tel_cel_caracteristica" name="tel_cel_caracteristica" class="input size-2" autocomplete="off">
					 <strong> ) </strong>
					<input type="number" id="tel_cel_numero" name="tel_cel_numero" class="input size-4" autocomplete="off">
				</div>
			</fieldset>
			<div class="group-inline size-12 sangria" align="center">
				<label>Crear usuario? </label>
				<select onChange="determinarCracionUsaurio()" id="crear_usuario" name="crear_usuario" class="input">
					<option id="1" value="NO" selected>NO</option>
					<option id="2" value="SI">SI</option>
				</select>
			</div>
			<br>
			<fieldset id="datos-usuario" name="datos-usuario" style="display:none">
				<legend>Datos de usuario</legend>
				<div class="group size-5 sangria required">
					<label>Nombre: </label>
					<input type="text" id="name" name="name" class="input size-6" autocomplete="off">

				</div>
				<div class="group size-3 sangria required">
					<label>E-mail: </label>
					<input type="email" id="email" name="email" class="input size-12" autocomplete="off">
				</div>
				<div class="group size-3 sangria required">
					<label>Contraseña: </label>
					<input type="password" id="password" name="password" class="input size-8" autocomplete="off">

				</div>
				<div id="rolesSel" class="group size-12 sangria required">
				</div> 
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Borrar" value="Borrar" class="button btn-form btn-gris">
				<input type="submit" name="Crear" value="Crear" class="button btn-form btn-azul" onclick="window.onbeforeunload = null">
			</div>
		</form>
	</section>
	<script type="text/javascript">
		function determinarCracionUsaurio(){
			var crearUsuario = document.getElementById("crear_usuario").value;
			if(crearUsuario == "SI"){
				document.getElementById("datos-usuario").style.display = "block";
			}else{
				document.getElementById("datos-usuario").style.display = "none";	
			}
		}
	</script>
@endsection