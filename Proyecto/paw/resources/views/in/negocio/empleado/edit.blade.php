@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script type="application/ld+json">
		{!! $ld !!} 
	</script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		@include('partials.menulayout')
		<form action="{{ route('in.empleados.actualizar', [$empleado->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="datos-personales">
				<legend>Datos personales</legend>
				<div class="group size-2 sangria">
					<label>Nombre: </label>
					<input type="text" id="nombre" name="nombre" value="{{ $empleado->nombre }}" class="input size-12" autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Apellido: </label>
					<input type="text" id="apellido" name="apellido" value="{{ $empleado->apellido }}" class="input size-12" autocomplete="off">
				</div>
				<div class="group-inline size-3 sangria">
					<label>Documento: </label>
					<br>
					<select id="tipo_documento" name="tipo_documento" class="input">
					@foreach($tiposDocumento as $tipo)
					    <option value="{{$tipo->id}}" @if($empleado->tipo_documento_id == $tipo->id) selected @endif >{{$tipo->descripcion}}</option>
					@endforeach
					</select>
					<input type="number" id="nro_documento" name="nro_documento" min="0" value="{{ $empleado->nro_documento }}" class="input size-6" autocomplete="off">
				</div>
				<div class="group size-2 sangria">
					<label>CUIL: </label>
					<input type="number" id="cuil" name="cuil" min="0" value="{{ $empleado->cuil }}" class="input size-12"  autocomplete="off">
				</div>
				<div class="group size-1 sangria">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($empleado->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($empleado->estado == 'I') selected @endif >Inactivo</option>
					</select>
				</div>
			</fieldset>
			<br>
			<fieldset name="datos-residencia">
				<legend>Datos de residencia</legend>
				<div class="group size-2 sangria">
					<label>Pais: </label>
					<input type="text" id="pais" name="pais" value="{{ $empleado->direcciones[0]->pais }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Provincia: </label>
					<input type="text" id="provincia" name="provincia" value="{{ $empleado->direcciones[0]->provincia }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Localidad: </label>
					<input type="text" id="localidad" name="localidad" value="{{ $empleado->direcciones[0]->localidad }}" class="input size-10" autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Domicilio: </label>
					<input type="text" id="domicilio" name="domicilio" value="{{ $empleado->direcciones[0]->domicilio }}" class="input size-12" autocomplete="off">
				</div>
			</fieldset>
			<br>
			<fieldset name="datos-contacto">
				<legend>Datos de contacto</legend>
				<div class="group-inline size-5 sangria">
					<label>Teléfono (Fijo): </label>
					<br>
					<strong>( </strong>
					<input type="number" id="tel_fijo_caracteristica" name="tel_fijo_caracteristica" @if(isset($telFijo['area'])) value="{{ $telFijo['area'] }}" @endif class="input size-2" autocomplete="off">
					 <strong> ) </strong>
					<input type="number" id="tel_fijo_numero" name="tel_fijo_numero" @if(isset($telFijo['numero'])) value="{{ $telFijo['numero'] }}" @endif class="input size-4" autocomplete="off">
				</div>
				<div class="group-inline size-5 sangria">
					<label>Teléfono (Celular): </label>
					<br>
					<strong>( </strong>
					<input type="number" id="tel_cel_caracteristica" name="tel_cel_caracteristica"  @if(isset($celular['area'])) value="{{ $celular['area'] }}" @endif class="input size-2" autocomplete="off">
					 <strong> ) </strong>
					<input type="number" id="tel_cel_numero" name="tel_cel_numero" @if(isset($celular['numero'])) value="{{ $celular['numero'] }}" @endif class="input size-4" autocomplete="off">
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