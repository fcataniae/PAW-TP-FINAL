<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Login </title>
		<link rel="stylesheet" href="{{asset('css/login.css')}}">
	</head>
	<body>
	    <main> 
			<form method="POST" action="{{ route('auth.login') }}">
				{{csrf_field()}}
				<div class="container">
			    	<label for="name"><b>Nombre</b></label>
			    	<input type="text" name="name"  value="{{ old('name') }}" placeholder="Ingrese Nombre" autocomplete="off">
					{!! $errors->first('name', '<span> :message </span>') !!}
					<br><br>
					<label for="password"><b>Password</b></label>
					<input type="password"  name="password" placeholder="Ingrese Password" autocomplete="off">
					{!! $errors->first('password', '<span> :message </span>') !!}
					<button type="submit">Login</button>
			  	</div>
			</form>
		</main>
	</body>
</html>
