var window = window || {},
    document = document || {},
    console = console || {};

var cliente = {};
var mercadopagoJS = "";
var mercadopagoPublicKey = "";

document.addEventListener("DOMContentLoaded", function () {
	cargarConfiguracionMP();
	clientesAll = JSON.parse(clientesAll);
	cargarListaClientes();
});

window.onunload = function(e) {
	if(factura != null){
		var f = JSON.parse(factura);
		ajaxWithFetch("PUT", '/in/facturas-ajax/' + f.id + '/reservar', null);
	}
  	return '';
};

window.onbeforeunload = function(e) {
  return '';
};

function cargarConfiguracionMP(){
	ajaxCallWithParametersAndRequest('GET','/in/facturas/datos-configuracion-mp', null, null,
		function(res){
			let datos = JSON.parse(res);
			mercadopagoJS = datos["mercadopagoJS"];
			mercadopagoPublicKey = datos["mercadopagoPublicKey"];
		},
		function(){		
			console.log("No se pudo cargar configuracion.");
	});
}

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
		console.log(cliente);
		document.getElementById("tipo_documento").value = cliente.tipo_documento_id;
		document.getElementById("nro_documento").value = cliente.nro_documento;
		document.getElementById("nombre").value = cliente.nombre;
		document.getElementById("apellido").value = cliente.apellido;
	}
}

function agregarCliente(){
	var tipo_documento = document.getElementById("tipo_documento");
	var request = { "tipo_documento": tipo_documento.value, 
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
			Array.prototype.slice.call(document.getElementById("tipo_documento").children).forEach( c =>{
				if(c.value == cliente.tipo_documento_id){
					c.selected = true;
				}
			});
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
	}else if(document.getElementById('forma_pago').value == 3){
		document.getElementById('forma_pago_efectivo').style.display = "inline-block";
		document.getElementById('Confirmar').value = "Continuar";
	}
}

// se realizan los controles necesarios y se desactiva onbeforeunload y onunload para poder avanzar
function enviar(event){
	if(event.submitter.defaultValue == "Pagar"){
		console.log("Se controla el pago en efectivo");
		if(document.getElementById('efectivo').value == null || document.getElementById('efectivo').value == ""){
			indicarError("Debe ingresar el pago.");
			return false;
		}else if(parseInt(document.getElementById('efectivo').value) < parseInt(document.getElementById('total').value)){
			indicarError("El pago debe ser mayor al total.");
			return false;
		}
	}

	if(event.submitter.defaultValue != "Continuar"){
		console.log("Se avanza sin uso de mercado pago.");

		// Se remueve el hidden creado para mercado pago en caso q exista
		var hidden = document.getElementById("confirmar");
		if(hidden){
	    	hidden.parentNode.removeChild(hidden);
		}

		window.onbeforeunload = null;
		window.onunload = null;

		//Es necesario debido a que MP inhabilita los demas botones del formulario; return true no funciona.
		var input = document.createElement("input");
		input.type = "hidden";
		input.name = event.submitter.name;
		input.value = event.submitter.name;

		document.getElementById("formulario").appendChild(input);
		document.getElementById("formulario").submit();
		//return true;
	}else{
		console.log("Se agrega mercado pago.");
		
		// Es necesario el hidden para que el back sepa que es una confirmacion, de lo contrario no recibe cual es la accion tomada
		var input = document.createElement("input");
		input.type = "hidden";
		input.id = "confirmar"
		input.name = "Confirmar";
		input.value = "Confirmar";
		document.getElementById("formulario").appendChild(input);

		let total = document.getElementById('total').value;
		if(document.getElementById('forma_pago').value == 3){
			let pagoEfectivo = document.getElementById('efectivo').value;
			total = total - pagoEfectivo;
		}

		if(total <= 0){
			indicarError("El total para pagar con tarjeta es menor (o igual) a 0.");
			return false;
		}

		window.onbeforeunload = null;
		window.onunload = null;

		// Elimino el div que se puedo haber creado anteriormente
		var mpViejo = document.getElementsByClassName("mp-mercadopago-checkout-wrapper")[0];
		if(mpViejo){
			mpViejo.parentNode.removeChild(mpViejo);
		}

		var script = document.createElement('script');
		script.id = "mercadopago";
		script.src = mercadopagoJS;
		script.setAttribute("data-public-key", mercadopagoPublicKey);
		script.setAttribute("data-summary-product-label", "Total");
		script.setAttribute("data-summary-product", total);
		script.setAttribute("data-transaction-amount", total);
		script.setAttribute("data-open", "true");
		script.style.display = "none";
		document.getElementById("formulario").appendChild(script);
		setTimeout(() => {
			var mp = document.getElementsByClassName("mp-mercadopago-checkout-wrapper")[0];
			// en caso que se cierre MP necesito eliminar todo lo generado y volver a agregar los metodos unload y beforeunload
			mp.addEventListener('DOMNodeRemoved', function(){

				var hidden = document.getElementById("confirmar");
				if(hidden){
			    	hidden.parentNode.removeChild(hidden);
				}
				
				var script = document.getElementById("mercadopago");
				if(script){
					script.parentNode.removeChild(script);
				}

				window.onunload = function(e) {
					if(factura != null){
						var f = JSON.parse(factura);
						ajaxWithFetch("PUT", '/in/facturas-ajax/' + f.id + '/reservar', null);
					}
					return '';
				};

				window.onbeforeunload = function(e) {
					return '';
				};

			}, false);
		},2000);
		
		return false;
	}
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
	strong.innerHTML = msjExito;

	div.appendChild(span);
	div.appendChild(strong);
	exito.appendChild(div);
} 