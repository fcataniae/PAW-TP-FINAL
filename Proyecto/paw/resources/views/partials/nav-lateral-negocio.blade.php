<nav class="sidenav negocio close no-print">
	<div class="expand">
		<span>&#9776;</span>
		<strong class="unshow" style="margin-left: 5px">MENU</strong>
	</div>
	<ul class="unshow">

		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.permissions.listar')}}">Permisos</a></li>
		@endif
		
		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.roles.listar')}}">Roles</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.users.listar')}}">Usuarios</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.empleados.listar')}}">Empleados</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.clientes.listar')}}">Clientes</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.forma_pago.listar')}}">Formas de Pago</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.tipos_documento.listar')}}">Tipos de Documento</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
			<li><a href="{{route('in.generos.listar')}}">Generos</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.categorias.listar')}}">Categorias Producto</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.tipos.listar')}}">Tipos Producto</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.talles.listar')}}">Talles Producto</a></li>
		@endif

		@if(Entrust::can('gestionar_negocio'))
		    <li><a href="{{route('in.productos.listar')}}">Productos</a></li>
		@endif
	</ul>
</nav>
