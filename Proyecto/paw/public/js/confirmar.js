var window = window || {},
    document = document || {},
    console = console || {};

var cliente = {};

document.addEventListener("DOMContentLoaded", function () {
	clientesAll = JSON.parse(clientesAll);
	cargarClientes();
});

function cargarClientes(){
	var datalist = document.getElementById("clientes_data");
	clientesAll.forEach(c => {
		option = document.createElement('option');
	    option.value =  c.id;
	    option.innerHTML = c.apellido + ", " + c.nombre;
	    datalist.appendChild(option);
	});
}

function determinarCliente(){
	var esCliente = document.getElementById("es_cliente").value;
	if(esCliente == "SI"){
		document.getElementById("datos_cliente").style.display = "inline-block";	
		document.getElementById("tipo_documento").disabled = true;
		document.getElementById("nro_documento").readOnly = true;
		document.getElementById("nombre").readOnly = true;
		document.getElementById("apellido").readOnly = true;
		document.getElementById("btnAddCliente").style.display = "none";	
	}else{
		document.getElementById("datos_cliente").style.display = "none";
		document.getElementById("tipo_documento").disabled = false;
		document.getElementById("nro_documento").readOnly = false;
		document.getElementById("nombre").readOnly = false;
		document.getElementById("apellido").readOnly = false;
		document.getElementById("btnAddCliente").style.display = "inline-block";
	}
	limpiarCamposCliente();
}

function limpiarCamposCliente(){
	document.getElementById("nro_cliente").value = null;
	document.getElementById("nro_documento").value = null;
	document.getElementById("nombre").value = null;
	document.getElementById("apellido").value = null;
}

function cargarCliente(){
	var nro_cliente = document.getElementById("nro_cliente").value;
	if(nro_cliente){
		cliente = clientesAll.find(c => c.id == nro_cliente);
		document.getElementById("tipo_documento").value = cliente.tipo_documento;
		document.getElementById("nro_documento").value = cliente.nro_documento;
		document.getElementById("nombre").value = cliente.nombre;
		document.getElementById("apellido").value = cliente.apellido;
	}
}

function agregarCliente(){
	var tipo_documento = document.getElementById("tipo_documento");
	var request = { "tipo_documento": tipo_documento[tipo_documento.selectedIndex].id, 
					"nro_documento": document.getElementById("nro_documento").value, 
					"nombre": document.getElementById("nombre").value,
					"apellido": document.getElementById("apellido").value };
	console.log(request);
	ajaxCallWithParametersAndRequest('POST','/in/clientes-ajax', null, request,
		function(cliente){
			indicarExito("El cliente se dio de alta exitosamente.");
			console.log(clientesAll);
			clientesAll.push(JSON.parse(cliente));
			console.log(clientesAll);
		},
		function(){		
			indicarError("No se pudo agregar cliente.");
	});
}

function indicarError(msjError){
	console.log(msjError);
} 

function indicarExito(msjExito){
	console.log(msjExito);
} 