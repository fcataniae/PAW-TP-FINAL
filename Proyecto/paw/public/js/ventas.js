nroDetalle = 0;

function addDetalles() {
	nroDetalle++;
	var fieldset = document.createElement('fieldset');
	
	var labelDescripcion = document.createElement('label');
	labelDescripcion.innerHTML = "Descripcion:";
	var inputDescripcion = document.createElement('input');
	inputDescripcion.type = "text";
    inputDescripcion.name = "descripcion_" + nroDetalle;
    inputDescripcion.readOnly = true;
	
	var labelPrecio = document.createElement('label');
	labelPrecio.innerHTML = "Precio:";
	var inputPrecio = document.createElement('input');
	inputPrecio.type = "number";
	inputPrecio.name = "precio_" + nroDetalle;
	inputPrecio.readOnly = true;


	var labelTalle = document.createElement('label');
	labelTalle.innerHTML = "Talle:";
	var selectTalle = document.createElement("select");
	selectTalle.name = "talle_" + nroDetalle;

	var array = ["S","M","X","XL"];
	for (var i = 0; i < array.length; i++) {
	    var option = document.createElement("option");
	    option.value = array[i];
	    option.text = array[i];
	    selectTalle.appendChild(option);
	}

	var labelCantidad= document.createElement('label');
	labelCantidad.innerHTML = "Cantidad:";
	var inputCantidad = document.createElement('input');
	inputCantidad.type = "number";
	inputCantidad.name = "cantidad_" + nroDetalle;
	inputCantidad.min = 0;

	fieldset.appendChild(labelDescripcion);
	fieldset.appendChild(inputDescripcion);
	fieldset.appendChild(labelPrecio);
	fieldset.appendChild(inputPrecio);
	fieldset.appendChild(labelTalle);
	fieldset.appendChild(selectTalle);
	fieldset.appendChild(labelCantidad);
	fieldset.appendChild(inputCantidad);
	
	document.getElementById('formulario').appendChild(fieldset);
}