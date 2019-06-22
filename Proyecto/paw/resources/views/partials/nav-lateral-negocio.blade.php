<nav>
	<ul>
		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Roles</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Permisos</a></li>
		@endif
		
		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Usuarios</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Empleados</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Clientes</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
			<li><a href="#">Generos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Categorias Productos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Tipos Productos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Talles Productos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Productos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Tipos de Documentos</a></li>
		@endif

		@if(Entrust::can('roles_administrador'))
		    <li><a href="#">Formas de Pago</a></li>
		@endif
	</ul>
</nav>