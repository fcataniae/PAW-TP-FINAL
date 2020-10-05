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
		<form action="{{ route('in.tipos_documento.guardar')}}" method="POST">
			{{ csrf_field() }}
			<fieldset name="tipo-documento">
				<div class="group size-12 sangria required">
					<label>Descripcion: </label>
					<input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="textarea size-6"  autocomplete="off">
				</div>
			</fieldset>
			<br>
			<div align="center">
				<input type="reset" name="Borrar" value="Borrar" class="button btn-form btn-gris">
				<input type="submit" name="Crear" value="Crear" class="button btn-form btn-azul" onclick="window.onbeforeunload = null">
			</div>
		</form>
	</section>
@endsection