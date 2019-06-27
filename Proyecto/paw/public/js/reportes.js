var window = window || {},
    document = document || {},
    console = console || {};

window.onload = function(){
  onloadwindow();
  initWindow();
  ajaxCall('GET','/in/forma_pago/all',completeFormaPago);
  ajaxCall('GET','/in/empleados/all',completeEmpleado);
}

const filtros =  ['id','importe_desde','importe_hasta','fecha_desde','fecha_hasta','empleado_id','cliente_id','forma_pago_id','estado'];
var facturas = [];
function initWindow(){

  let input = document.querySelector('section.main input.button-clean');
  input.addEventListener('click',doSearch);
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

const labels = ['nro','importe','fecha creacion','empleado','cliente','forma pago','estado'];

function printTable(res){
  facturas = JSON.parse(res);

  var table,thead,tbody,th,tr,td;
  let container = document.querySelector('section.main div.container-reportes');
  table = document.querySelector('section.main div.container-reportes table.table');

  if(table){
    table.innerHTML = '';
  }else{
    table = document.createElement('table')
    table.classList.add('table');
    table.classList.add('table-mg');
  }
  thead = document.createElement('thead');
  tbody = document.createElement('tbody');

  table.appendChild(thead);
  table.appendChild(tbody);

  for(let i = 0; i< labels.length; i++){
    th = document.createElement('th');
    th.innerHTML = labels[i];
    th.classList.add('th');
    th.addEventListener('click',sort);
    thead.appendChild(th);
  }


  for(let i = 0; i< facturas.length;i++){
    tr = document.createElement('tr');
    td = document.createElement('td');
    td.innerHTML = facturas[i].id;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].importe;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].fecha_creacion;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].empleado_id;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = (facturas[i].cliente_id)?facturas[i].cliente_id: 'No seleccionado';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = (facturas[i].forma_pago_id) ?facturas[i].forma_pago_id : 'No seleccionado';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].estado;
    tr.appendChild(td);
    tbody.appendChild(tr);
  }


  table.classList.add('table');
  container.appendChild(table);


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


function sort($event){
  console.log($event.srcElement.innerHTML);
  let th = $event.srcElement;
  let column = th.innerHTML;
  let sortup =  th.classList.contains('sort-up');
  let sortdown =  th.classList.contains('sort-down');
  if(!sortup || !sortdown){
    if(sortdown){
      th.classList.add('sort-up');
      th.classList.remove('sort-down');
    }else{
      th.classList.remove('sort-up');
      th.classList.add('sort-down');
    }
    facturas = facturas.sort(function(a,b){
      if(column == 'nro'){
        return (sortup ? a.id-b.id: b.id-a.id);
      }else if (column == 'importe'){
        return (sortup ? a.importe-b.importe: b.importe-a.importe);
      }else if (column == 'empleado'){
        return (sortup ? a.empleado_id.localeCompare(b.empleado_id): b.empleado_id.localeCompare(a.empleado_id));
      }else if (column == 'cliente'){
        return (sortup ?  a.cliente_id.localeCompare(b.cliente_id): b.cliente_id.localeCompare(a.cliente_id));
      }else if (column == 'forma pago'){
        return (sortup ? a.forma_pago_id.localeCompare(b.forma_pago_id): b.forma_pago_id.localeCompare(a.forma_pago_id));
      }else if (column == 'estado'){
        return (sortup ?  a.estado.localeCompare(b.estado): b.estado.localeCompare(a.estado));
      }else if (column == 'fecha creacion'){
        return (sortup ? a.fecha_creacion>b.fecha_creacion: b.fecha_creacion>a.fecha_creacion);
      }
    });
  }
  rePrintSortedData();
}

function rePrintSortedData(){

  var tbody,th,tr,td;
  tbody = document.querySelector('table.table tbody');


  tbody.innerHTML = '';

  for(let i = 0; i< facturas.length;i++){
    tr = document.createElement('tr');
    td = document.createElement('td');
    td.innerHTML = facturas[i].id;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].importe;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].fecha_creacion;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].empleado_id;
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = (facturas[i].cliente_id)?facturas[i].cliente_id: 'No seleccionado';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = (facturas[i].forma_pago_id) ?facturas[i].forma_pago_id : 'No seleccionado';
    tr.appendChild(td);
    td = document.createElement('td');
    td.innerHTML = facturas[i].estado;
    tr.appendChild(td);
    tbody.appendChild(tr);
  }

}

function showError(res,stat){
  console.log(res);
  console.log(stat);
  openErrorDialog(res);
}
