@if(Auth::user() != null)
	<a href={{ route('in') }}>
		<img class="logo" src="/img/logo.png" alt="" width="40" height="40"/>
	</a>
@endif

<nav>
	<ul class="main-nav">
		@if(Entrust::can('gestionar_negocio'))
			<li class="negocio menu"><a href="#">Negocio</a></li>
	    @endif

	    @if(Entrust::can('gestionar_venta'))
		    <li class="venta menu"><a href="#">Ventas</a></li>
	    @endif

	    @if(Entrust::can('gestionar_inventario'))
		    <li class="inventario menu"><a href="#">Inventario</a></li>
	    @endif

	    @if(Entrust::can('gestionar_reporte'))
		    <li class="reporte menu"><a href="{{ route('in.reportes')}}">Reporte</a></li>
	    @endif

	    <li class="perfil menu">
	    	<a>
	    		<img class="avatar" src="/img/fotoPerfil.jpg" alt=""/>
	    		<strong>{{ Auth::user()->name }}</strong>
	    	</a>
	        <ul class="submenu">
	        	<li class="submenu1"><a href={{ route('in.users.edit.datospersonal') }}>Datos Personales</a></li>
	            <li class="submenu2"><a href={{ route('in.users.edit.datoscuenta') }}>Configurar Cuenta</a></li>
	            <li class="submenu3"><a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
	        </ul>
	    </li>
	</ul>
</nav>

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
