@extends('layouts.main')

@section('head-css')
	<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
	<link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.css')}}">

@endsection

@section('head-js')
	<script src="{{asset('js/filtros.js')}}"></script>
	<script src="{{asset('js/tabla.js')}}"></script>
	<script src="{{asset('js/ajax.js')}}"></script>
	<script src="{{asset('js/utils.js')}}"></script>
	<script>
		var columnas;
		var datos;
		var filtros = '{!! $filtros !!}';
		document.addEventListener("DOMContentLoaded", () => {
			filters = filtros;
			filterUrl = '/in/factura';
			drawFilters();

			
			async function showDetails(nroFac){
				
				let response = await fetch(`/in/factura/get/detalles/${nroFac}`);
				let detalles = await response.json();
				let table,thead,tbody,tr,td,th;
				const headers = ['producto','codigo','talle','precio','cantidad'];
				table = document.createElement('table');
				table.classList.add('table');
				tbody = document.createElement('tbody');
				thead = document.createElement('thead');
				for(let i = 0; i< headers.length ;i++){
				th = document.createElement('th');
				th.innerHTML = headers[i];
				thead.appendChild(th);
				}
				table.appendChild(thead);
				for(let i = 0; i< detalles.length ;i++){
				tr = document.createElement('tr');
				td = document.createElement('td');
				td.innerHTML = detalles[i].producto;
				tr.appendChild(td);
				td = document.createElement('td');
				td.innerHTML = detalles[i].codigo;
				tr.appendChild(td);
				td = document.createElement('td');
				td.innerHTML = detalles[i].talle;
				tr.appendChild(td);
				td = document.createElement('td');
				td.innerHTML = detalles[i].precio;
				tr.appendChild(td);
				td = document.createElement('td');
				td.innerHTML = detalles[i].cantidad;
				tr.appendChild(td);
				tbody.appendChild(tr);
				}
				table.appendChild(tbody);
				let container = document.createElement('div');
				container.appendChild(table);
				return container.outerHTML;
			}

			function getDetails(nroFac){
				return () => {
					return showDetails(nroFac);
				}
			}
			
			function addJsHandler(res){
				res.columnas.push({headerName: 'Detalle', field: 'accion', width: '10%'});
				res.registros.forEach(res => {
					nroFac = res.id;
					res['action'] = { js: true, content: getDetails(nroFac) };
				});
			}

			callbackFn = function printTable(res){
				res = JSON.parse(res);
				destroyTabla();
				addJsHandler(res);
				encabezados = res.columnas;
				registrosFiltrados = res.registros;
				registros = res.registros;
				construirTabla(encabezados, registros);
				paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
			}

			errorCalbackFn = function showError(res,stat){
				console.log(res);
				console.log(stat);
			}
		})

	</script>
	<style>
		table{
			table-layout: fixed;
		}
		td {
			word-wrap:break-word;
		}
		input {
			width: 100%;
			padding: 10px;
			margin: 0px;
		}
	</style>
	<script type="application/ld+json">
		{
		"@context": "https://schema.org",
		"@type": "Table",
		"about": "list of invoices"
		}
	</script>
@endsection
@section('body-header')
	@include('partials.nav-principal')
@endsection
@section('body-main')
	<section class="main">
		@include('partials.menulayout')
			<div id="filters"></div>
			<br>
		<div class="container-table">
			<div id="contenido"></div>
			<br>
			<div id="paginacion"></div>
		</div>
	</section>
@endsection