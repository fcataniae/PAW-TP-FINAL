<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> @yield('head-title','Default') </title>

		@yield('head-css')
	</head>
	<body>
	    <header class="header"> @yield('body-header') </header>
	    <main style="display:inline-block;"> @yield('body-main') </main>
	    <footer> @yield('body-footer') </footer>
	</body>
</html>
