<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1.0">
  		<title>Sin permisos</title>
  		<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
		<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">
	</head>
	<body class="body-sinpermisos">
		<h1>Ups!</h1>
		<h3>No tienes acceso a este lugar!</h3>
		<img src="../img/sinacceso.gif" alt="Sin acceso" />
		<br><br>
		<a href="{{ route('in') }}" class="button btn-gris" ><span><i class="fa fa-reply"></i></span> Volver a inicio</a>
	</body>
</html>
