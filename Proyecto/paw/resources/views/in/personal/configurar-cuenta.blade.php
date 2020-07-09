@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
@endsection

@section('head-js')
	<script src="{{asset('js/utils.js')}}"></script>
	<script src="{{asset('js/imagen.js')}}"></script>
@endsection

@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.alert-message')
		<p><strong>Datos Cuenta</strong></p>
		<fieldset id="datos-cuenta">
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
		<section class="datos-modificables">
			<form id="form-password" action="{{ route('in.users.actualizar.datoscuenta') }}" method="POST">
				{{method_field('PUT')}}
				{{ csrf_field() }}
				<fieldset id="cambiar-password">
					<legend>Cambiar contraseña</legend>
					<div class="group size-12 sangria">
						<label>Contraseña actual: </label>
						<input type="password" id="password_actual" name="password_actual" class="input size-6" autocomplete="off">
					</div>
					<div class="group size-12 sangria">
						<label>Nueva contraseña: </label>
						<input type="password" id="password_nuevo" name="password_nuevo" class="input size-6" autocomplete="off">
					</div>
					<div class="group size-12 sangria">
						<label>Confirmar contraseña: </label>
						<input type="password" id="password_confirmacion" name="password_confirmacion" class="input size-6" autocomplete="off">
					</div>
					<div align="center">
						<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul">
					</div>
				</fieldset>
				<br>
			</form>
		
			<form id="form-imagen" action="{{ route('in.users.actualizar.imagencuenta') }}" method="POST" enctype="multipart/form-data">
				{{method_field('PUT')}}
				{{ csrf_field() }}
				<fieldset id="cambiar-imagen">
					<legend>Cambiar imagen</legend>
					<div class="group size-12 sangria">
						<label>Imagen: </label>
						<div class="imagen-all">
							<input id="img_default" name="img_default" type="hidden" value="/img/fotoPerfil.jpg">
							<input id="imagen_cambiada" name="imagen_cambiada" type="hidden" value="0">
							@if ((Auth::user()->imagen == null))
			                	<input id="img_usuario_anterior" name="img_usuario_anterior" type="hidden" value="{{asset('/img/fotoPerfil.jpg')}}">
			                   	<div class="imagen-visual">
									<img class="avatar-grande" id="imagen_usuario" src="{{asset('/img/fotoPerfil.jpg')}}" alt="" />
									<br>
									<span class="eliminar-imagen" id="imagen_eliminar" aria-hidden="true"> Eliminar Imagen</span>
								</div>
			             	@else
			                	<input id="img_usuario_anterior" name="img_usuario_anterior" type="hidden" value="{{asset('img/usuarios').'/'.Auth::user()->imagen}}">
								<div class="imagen-visual">
									<img class="avatar-grande" id="imagen_usuario" src="{{asset('img/usuarios').'/'.Auth::user()->imagen}}" alt="" />
									<br>
									<span class="eliminar-imagen" id="imagen_eliminar" aria-hidden="true"> Eliminar Imagen</span>
								</div>
			                @endif
							<div class="imagen-info">
								<p>La imagen debe ser jpg, jpeg, png o gif y no pesar más de 500 kb</p>
							</div>
						</div>
						<br>
						<input multiple="multiple" accept="image/jpg, image/jpeg, image/png, image/gif, " id="imagen_load" name="imagen_load" type="file">
						<br>
						<div class="error-imagen">
							<span>La imagen debe pesar menos de 500 kb</span>
						</div>
					</div>
					<div align="center">
						<input type="submit" name="Guardar" value="Guardar" class="button btn-form btn-azul">
					</div>
				</fieldset>
			</form>
		</section>	
	</section>
@endsection