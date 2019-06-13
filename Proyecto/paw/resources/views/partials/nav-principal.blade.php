<nav>
	<ul class="main-nav">
		<li><a href="#">Negocio</a></li>
	    <li><a href="#">Ventas</a></li>
	    <li><a href="#">Inventario</a></li>
	    <li><a href="#">Reporte</a></li>
	    <li><a><strong>{{ Auth::user()->name }}</strong></a>
	        <ul>
	        	<li><a href={{ route('in.inicio') }}>Datos Personales</a></li>
	            <li><a href={{ route('in.inicio') }}>Configurar Cuenta</a></li>
	            <li><a href="{{route('auth.logout')}}">Logout</a></li>
	        </ul>
	    </li>
	</ul>
</nav>