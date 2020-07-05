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
		<p><strong>Modificar Forma de Pago</strong></p>
		<form action="{{ route('in.talles.actualizar', [$talle->id]) }}" method="POST">
			{{method_field('PUT')}}
			{{ csrf_field() }}
			<fieldset name="talle">
				<div class="group size-8 sangria">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" value="{{ $talle->descripcion }}" class="textarea size-9"  autocomplete="off">
				</div>
				<div class="group size-3 sangria">
					<label>Estado: </label>
					<select id="estado" name="estado" class="input">
					    <option value="A" @if($talle->estado == 'A') selected @endif >Activo</option>
					    <option value="I" @if($talle->estado == 'I') selected @endif >Inactivo</option>
					</select>
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