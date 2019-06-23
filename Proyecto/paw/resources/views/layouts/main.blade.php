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
	    <header class="header"> @yield('body-header') </header>
	    <main> @yield('body-main') </main>
	    <footer class="main"> @yield('body-footer') </footer>
	</body>
</html>
