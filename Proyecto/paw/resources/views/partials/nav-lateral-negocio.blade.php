<nav class="sidenav negocio close no-print">
	<span class="expand">&#9776;</span>

	<ul class="unshow">
		@if(Entrust::can('permisos_administrador'))
			<li><a href="#">Roles</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
			<li><a href="{{route('in.permissions.listar')}}">Permisos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
			<li><a href="#">Usuarios</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
			<li><a href="#">Empleados</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
			<li><a href="#">Clientes</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
			<li><a href="#">Generos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Categorias Productos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Tipos Productos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Talles Productos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Productos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Tipos de Documentos</a></li>
		@endif

		@if(Entrust::can('permisos_administrador'))
		    <li><a href="#">Formas de Pago</a></li>
		@endif
	</ul>
</nav>
