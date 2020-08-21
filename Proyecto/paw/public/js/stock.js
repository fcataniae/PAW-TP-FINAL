var window = window || {},
    document = document || {},
    console = console || {};

var producto = {},
	nroDetalle = 0;

document.addEventListener("DOMContentLoaded", function () {
		productosAll = JSON.parse(productosAll);
		detallesAll = JSON.parse(detalles);
		opcionesValoresABuscar();
});


function opcionesValoresABuscar(){
	var datalist = document.getElementById("valor_a_buscar_data");
	datalist.innerHTML = "";
	productosAll.forEach(p => {
	    option = document.createElement('option');
	    option.value =  p.codigo;
	    option.innerHTML = p.categoria + ", " + p.tipo + ", " + p.descripcion + ", " + p.talle;
	    datalist.appendChild(option);
	});
};

function agregarProducto(){

	if(window.onbeforeunload == null){
		window.onbeforeunload = function(e) {
			return '';
		};
	}
	
	var valor_a_buscar = document.getElementById("valor_a_buscar").value;
	if(valor_a_buscar){
		producto = productosAll.find(p => p.codigo == valor_a_buscar);
		if(producto.stock <= 0){
			indicarError("Producto sin stock.");
		}else{
			producto.cantidad = 0;
			var seleccionado = controlarProductoSeleccionado(producto);
			if(!seleccionado){
				nroDetalle++;
				agregarFila(producto,nroDetalle);
				limpiarCampos();
				var error = document.getElementById('msjError');
				error.innerHTML = "";
			}else{
				indicarError("Producto ya seleccionado.");
			}
		}
	}
}

function controlarProductoSeleccionado(producto){
	var length = document.getElementById("tabla_detalles").rows.length;
	var encontrado = false;
	var i = 1;
	while ( !encontrado && i < length ){
		if(producto.codigo == document.getElementById("tabla_detalles").rows[i].getAttribute("data-codigo")){
			encontrado = true;
		}
	  i++;
	}
	return encontrado;
} 

function agregarFila(producto, nroDetalle){
	var table  = document.getElementById("tabla_detalles").getElementsByTagName('tbody')[0];
	var row = table.insertRow();
	row.id = "nro_detalle_" + nroDetalle;
	row.setAttribute("data-codigo", producto.codigo);
  	
  	var genero = row.insertCell();
  	genero.id = "genero_" + nroDetalle; 
  	genero.innerHTML = producto.genero;

  	var categoria = row.insertCell();
  	categoria.id = "categoria_" + nroDetalle; 
  	categoria.innerHTML = producto.categoria;

	var tipo = row.insertCell();
  	tipo.id = "tipo_" + nroDetalle; 
  	tipo.innerHTML = producto.tipo;
  	
  	let descripcion = row.insertCell();
  	descripcion.id = "producto_" + nroDetalle; 
  	descripcion.innerHTML = producto.descripcion;
  	var inputProducto = document.createElement('input');
	inputProducto.type = "hidden";
	inputProducto.name = "producto_id[]";
	inputProducto.value = producto.id;
	descripcion.appendChild(inputProducto);
  	
  	var talle = row.insertCell();
  	talle.id = "talle_" + nroDetalle; 
  	talle.innerHTML = producto.talle;
  	

  	var cantidad = row.insertCell();
  	cantidad.style.textAlign = "center"; 
  	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.name = "producto_cantidad[]";
	inputCantidad.id = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;
	inputCantidad.value = producto.cantidad;
	inputCantidad.className = "input";
  	cantidad.appendChild(inputCantidad);


  	var accion = row.insertCell();
  	accion.style.textAlign = "center";
  	
  	var btnEditar = document.createElement('button');
  	btnEditar.id = "editar_" + nroDetalle;
  	btnEditar.type = "button";
  	btnEditar.style.display = "none";
  	btnEditar.className = "button-table btn-azul";
  	btnEditar.addEventListener("click", function(){
  		editarDetalle(nroDetalle);
  	});
  	btnEditar.innerHTML = "<i class='fa fa-pencil' aria-hidden='true'></i>";
  	accion.appendChild(btnEditar);
  	
  	var btnDeshacer = document.createElement('button');
  	btnDeshacer.id = "deshacer_" + nroDetalle;
  	btnDeshacer.type = "button";
  	btnDeshacer.style.display = "none";
  	btnDeshacer.className = "button-table btn-celeste";
  	btnDeshacer.addEventListener("click", function(){
  		deshacerCambios(nroDetalle);
  	});
  	btnDeshacer.innerHTML = "<i class='fa fa-undo' aria-hidden='true'>";
  	accion.appendChild(btnDeshacer);
  	
   	var btnGuardar = document.createElement('button');
  	btnGuardar.id = "guardar_" + nroDetalle;
  	btnGuardar.type = "button";
  	btnGuardar.style.display = "inline";
  	btnGuardar.className = "button-table btn-verde";
  	btnGuardar.addEventListener("click", function(){
  		guardarCambios(nroDetalle);
  	});
  	btnGuardar.innerHTML = "<i class='fa fa-floppy-o' aria-hidden='true'>";
  	accion.appendChild(btnGuardar);
  	
  	var btnEliminar = document.createElement('button');
  	btnEliminar.id = "eliminar_" + nroDetalle;
  	btnEliminar.type = "button";
  	btnEliminar.style.display = "inline";
  	btnEliminar.className = "button-table btn-rojo";
  	btnEliminar.addEventListener("click", function(){
  		eliminarDetalle(nroDetalle);
  	});
  	btnEliminar.innerHTML = "<i class='fa fa-trash-o' aria-hidden='true'></i>";
  	accion.appendChild(btnEliminar);
}


function limpiarCampos(){
	document.getElementById("valor_a_buscar").value = null;
}

function editarDetalle(id){
	document.getElementById("cantidad_" + id).readOnly = false;
	document.getElementById("cantidad_" + id).setAttribute("data-value-old", document.getElementById("cantidad_" + id).value);
	document.getElementById("editar_" + id).style.display = "none";
	document.getElementById("eliminar_" + id).style.display = "none";
	document.getElementById("guardar_" + id).style.display = "inline";
	document.getElementById("deshacer_" + id).style.display = "inline";
}

function guardarCambios(id){
	var cantidad = document.getElementById("cantidad_" + id).value;
	console.log(cantidad);
	if(cantidad <= 0){
		indicarError("Cantidad solicitada debe ser mayor a cero.");
	} else{
		document.getElementById("cantidad_" + id).readOnly = true;
		document.getElementById("editar_" + id).style.display = "inline";
		document.getElementById("eliminar_" + id).style.display = "inline";
		document.getElementById("guardar_" + id).style.display = "none";
		document.getElementById("deshacer_" + id).style.display = "none";
	}
}


function eliminarDetalle(id){
	var detalle = document.getElementById('nro_detalle_' + id);
	detalle.parentNode.removeChild(detalle);
}

function deshacerCambios(id){
	document.getElementById("cantidad_" + id).readOnly = true;
	document.getElementById("cantidad_" + id).value = document.getElementById("cantidad_" + id).getAttribute("data-value-old");
	document.getElementById("editar_" + id).style.display = "inline";
	document.getElementById("eliminar_" + id).style.display = "inline";
	document.getElementById("guardar_" + id).style.display = "none";
	document.getElementById("deshacer_" + id).style.display = "none";	
}

// Se controla la correcta carga de cantidad por producto y se desactiva onbeforeunload para poder avanzar
function enviar(event){
	
	let correctaCarga = true;
	let imagenCargada = false;
	var length = document.getElementById("tabla_detalles").rows.length;
	for(var i = 1; i < length; i++){
		let cantidad = parseInt(document.getElementById("tabla_detalles").rows[i].cells[5].children[0].value);
		if(cantidad <= 0){
			correctaCarga = false;
			break;
		}
	}
	var remito = document.getElementById('remito_img');
	imagenCargada = remito.files.length != 0;
	if(!imagenCargada){
		indicarError("Debe adjuntar la imagen del remito!");
		return false;
	}else if(!correctaCarga){
		indicarError("Se detectaron productos sin cantidad definida.");
		return false;
	}else{
		window.onunload = null;
		window.onbeforeunload = null;
		return true;
	}
}

function indicarError(msjError){
	var error = document.getElementById('msjError');

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

