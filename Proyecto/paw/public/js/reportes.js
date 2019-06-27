var window = window || {},
    document = document || {},
    console = console || {};

window.onload = function(){
  onloadwindow();
  initWindow();
}

const filtros =  ['id','importe_desde','importe_hasta','fecha_desde','fecha_hasta','empleado_id','cliente_id','forma_pago_id','estado'];

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
  let facturas = JSON.parse(res);

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
function sort(){

}

function showError(res,stat){
}
