<nav>
	<ul class="main-nav">
		@if(Entrust::can('gestionar_negocio'))
			<li class="negocio"><a href="#">Negocio</a></li>
	    @endif

	    @if(Entrust::can('gestionar_venta'))
		    <li class="venta"><a href="#">Ventas</a></li>
	    @endif

	    @if(Entrust::can('gestionar_inventario'))
		    <li class="inventario"><a href="#">Inventario</a></li>
	    @endif

	    @if(Entrust::can('gestionar_reporte'))
		    <li class="reporte"><a href="{{ route('in.reportes')}}">Reporte</a></li>
	    @endif

	    <li><a><strong>{{ Auth::user()->name }}</strong></a>
	        <ul>
	        	<li><a href={{ route('in.users.edit.datospersonal') }}>Datos Personales</a></li>
	            <li><a href={{ route('in.users.edit.datoscuenta') }}>Configurar Cuenta</a></li>
	            <li><a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout</a></li>
	        </ul>
	    </li>
	</ul>
</nav>

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
