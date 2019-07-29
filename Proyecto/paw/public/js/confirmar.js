var window = window || {},
    document = document || {},
    console = console || {};

var cliente = {};

document.addEventListener("DOMContentLoaded", function () {
	clientesAll = JSON.parse(clientesAll);
	cargarListaClientes();
});

function cargarListaClientes(){
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
			cliente = JSON.parse(cliente);
			clientesAll.push(cliente);
			console.log(clientesAll);
			document.getElementById("es_cliente").value = "SI";
			document.getElementById("nro_cliente").value = cliente.id;
			document.getElementById("datos_cliente").style.display = "inline-block";	
			document.getElementById("tipo_documento").disabled = true;
			document.getElementById("nro_documento").readOnly = true;
			document.getElementById("nombre").readOnly = true;
			document.getElementById("apellido").readOnly = true;
			document.getElementById("btnAddCliente").style.display = "none";	
			cargarCliente();
			cargarListaClientes();
		},
		function(){		
			indicarError("No se pudo agregar cliente.");
	});
}

function confirmarCompra(){
	if(document.getElementById('forma_pago').value == 1){
		console.log(document.getElementById('efectivo').value );
		if(document.getElementById('efectivo').value == null || document.getElementById('efectivo').value == ""){
			indicarError("Debe ingresar el pago.");
		}else if(parseInt(document.getElementById('efectivo').value) < parseInt(document.getElementById('total').value)){
			indicarError("El pago debe ser mayor al total.");
		}else{
			var input = document.createElement("input");
			input.type = "hidden";
			input.value = "Confirmar";
			input.name = "Confirmar";
			document.getElementById("formulario").appendChild(input);
			document.getElementById("formulario").submit();
		}
	}else if(document.getElementById('forma_pago').value == 2){
		var input = document.createElement("input");
		input.id = "confirmar"
		input.type = "hidden";
		input.value = "Confirmar";
		input.name = "Confirmar";
		document.getElementById("formulario").appendChild(input);

		var script = document.createElement('script');
		script.id = "mercadopago";
		script.src = "https://www.mercadopago.com.ar/integrations/v1/web-tokenize-checkout.js";
		script.setAttribute("data-public-key", "TEST-22871e7e-19c6-4dc9-8a7e-fbfdf88e459c");
		script.setAttribute("data-summary-product-label", "Total");
		script.setAttribute("data-summary-product", document.getElementById('total').value);
		script.setAttribute("data-transaction-amount", document.getElementById('total').value);
		script.setAttribute("data-open", "true");
		script.style.display = "none";
		document.getElementById("formulario").appendChild(script);
	}
}

function definirFormaPago(){
	if(document.getElementById('forma_pago').value == 1){
		document.getElementById('forma_pago_efectivo').style.display = "inline-block";
		document.getElementById('Confirmar').value = "Pagar";
		var hidden = document.getElementById("confirmar");
		if(hidden){
	    	hidden.parentNode.removeChild(hidden);
		}
		var script = document.getElementById("mercadopago");
		if(script){
			script.parentNode.removeChild(script);
		}
	}else if(document.getElementById('forma_pago').value == 2){
		document.getElementById('forma_pago_efectivo').style.display = "none";
		document.getElementById('Confirmar').value = "Continuar";
	}
}

//es necesario ya que el script de mercadopago anula la funcionalidad de los botones del formulario
function avanzar(boton){
	var hidden = document.getElementById("confirmar");
	if(hidden){
		hidden.parentNode.removeChild(hidden);
	}
	var input = document.createElement("input");
	input.type = "hidden";
	input.value = boton;
	input.name = boton;
	document.getElementById("formulario").appendChild(input);
	document.getElementById("formulario").submit();
}

function indicarError(msjError){
	console.log(msjError);
	var error = document.getElementById('msjInfo');

	var div = document.createElement('div');
	div.className = "form-error";
	div.style.marginBottom = "10px";

	var span = document.createElement('span');
	span.className = "close-message";
	span.innerHTML = "X";
	span.onclick = function() {
	  span.parentNode.style.display = 'none';
	}

	var strong = document.createElement('strong');
	strong.innerHTML = msjError;

	div.appendChild(span);
	div.appendChild(strong);
	error.appendChild(div);
} 

function indicarExito(msjExito){
	console.log(msjExito);
	var exito = document.getElementById('msjInfo');

	var div = document.createElement('div');
	div.className = "form-success";
	div.style.marginBottom = "10px";

	var span = document.createElement('span');
	span.className = "close-message";
	span.innerHTML = "X";
	span.onclick = function() {
	  span.parentNode.style.display = 'none';
	}

	var strong = document.createElement('strong');
	strong.innerHTML = msjError;

	div.appendChild(span);
	div.appendChild(strong);
	exito.appendChild(div);
} 