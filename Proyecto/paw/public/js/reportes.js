var window = window || {},
    document = document || {},
    console = console || {};

document.addEventListener("DOMContentLoaded", function () {
  initWindow();
  ajaxCall('GET','/in/forma_pago/all',completeFormaPago);
  ajaxCall('GET','/in/empleados/all',completeEmpleado);
});

const filtros =  ['id','importe_desde','importe_hasta','fecha_desde','fecha_hasta','empleado_id','cliente_id','forma_pago_id','estado'];

var facturas = [];

function initWindow(){

  let input = document.querySelector('section.main input.button-clean');
  input.addEventListener('click', doSearch);
}

function doSearch(){
  let arr = [];

  for(let i = 0; i < filtros.length; i++){
    console.log(filtros[i]);
    let value = document.querySelector('input.form-input.minified#'+ filtros[i]).value;
    if(value && value.trim() != ''){
        let param = {
          'query' : filtros[i],
          'value' : value
        };
        arr.push(param);
    }
  }
  ajaxCallWParameters('GET','/in/filter/facturas',arr,printTable,showError);
}


function printTable(res){
  res = JSON.parse(res);
  destroyTabla();
  addJsHandler(res);
  encabezados = res.columnas;
  registrosFiltrados = res.registros;
  registros = res.registros;
  construirTabla(encabezados, registros);
  paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
}

function addJsHandler(res){
  res.columnas.push({headerName: 'Detalle', field: 'accion', width: '10%'});
  res.registros.forEach(res => {
    nroFac = res.id;
    res['action'] = { js: returnDetails( nroFac) };
  });
}

function showError(res,stat){
  console.log(res);
  console.log(stat);
}

function completeEmpleado(res){

  let emps = JSON.parse(res);
  let datalist = document.querySelector('datalist#empleados_data');
  let option;
  emps.forEach(e => {
    option = document.createElement('option');
    option.value = e.id;
    option.innerHTML = e.nombre + ' ' + e.apellido;
    datalist.appendChild(option);
  });

}
function completeFormaPago(res){

  let formas = JSON.parse(res);
  let datalist = document.querySelector('datalist#forma_pago_data');
  let option;
  formas.forEach(f => {
    option = document.createElement('option');
    option.value =  f.id;
    option.innerHTML = f.descripcion;
    datalist.appendChild(option);
  });

}

function returnDetails( nroFac) {
  
  return () => {
    showDetails(nroFac);
  }
}

function showDetails(nroFac){
  console.log('factura nro: ' + nroFac);
  ajaxCall('GET','/in/factura/get/detalles/'+nroFac, function(res){
    let detalles =JSON.parse(res);
    console.log(detalles);
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
    openDialog('Detalles de factura nro: '+nroFac, container);
  });
}

function openDialog(headertxt,container){
  let dialog = document.querySelector('dialog#fac-details');
  dialog.innerHTML = '';
  let header = document.createElement('header');
  let input = document.createElement('input');
  input.type = 'submit';
  input.value= 'cerrar';
  input.addEventListener('click',function(){
    let dialog = document.querySelector('dialog#fac-details');
    dialog.close();
  });
  input.classList.add('button-volver');

  header.innerHTML = headertxt;
  header.classList.add('dialog-header');
  dialog.appendChild(header);

  container.classList.add('dialog-content');
  container.appendChild(input);
  dialog.appendChild(container);

  dialog.classList.add('site-dialog');
  dialog.show();
}
