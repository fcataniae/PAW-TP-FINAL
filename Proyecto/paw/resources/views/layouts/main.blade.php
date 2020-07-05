<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> @yield('head-title','Default') </title>
		@yield('head-js')
		@yield('head-css')
	</head>
	<body>
	    <header class="header no-print"> 
	    	@yield('body-header') 
	    </header>
	    <main> 
			@include('partials.nav-lateral-negocio')
			@include('partials.nav-lateral-inventario')
			@include('partials.nav-lateral-ventas')
			@yield('body-main') 
		</main>
	    <footer class="main no-print">
	    	@yield('body-footer') 
	 	</footer>
	</body>
</html>
