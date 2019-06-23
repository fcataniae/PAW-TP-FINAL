var window = window || {},
    document = document || {},
    console = console || {};

const labels = ['id','descripcion','estado','codigo','precio costo','precio venta', 'talle', 'stock'];

var stock = {};
var stockFiltrado = {};
var timeout;
window.onload = function(){
  onloadwindow();
  ajaxCall("GET","productos",generateTable);
}

function generateTable(res){

    createFilters();
    stock = JSON.parse(res);
    var table,thead,tbody,th,tr,td;
    var container = document.querySelector('section.main div.container-table');

    table = document.createElement('table');
    thead = document.createElement('thead');
    tbody = document.createElement('tbody');

    table.appendChild(thead);
    table.appendChild(tbody);

    for(let i = 0; i< labels.length; i++){
      th = document.createElement('th');
      th.innerHTML = labels[i];
      th.classList.add('th');
      thead.appendChild(th);
    }

    for(let i = 0; i< stock.length;i++){
      tr = document.createElement('tr');
      td = document.createElement('td');
      td.innerHTML = stock[i].id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].descripcion;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].estado;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].codigo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].precio_costo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].precio_venta;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].talle_id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stock[i].stock;
      tr.appendChild(td);
      tbody.appendChild(tr);
    }

    table.classList.add('table');

    container.appendChild(table);

}

function createFilters(){

  var container = document.querySelector('section.main');
  var table = document.querySelector('section.main div.container-table')
  var div = document.createElement('div');
  div.classList.add('search-filters');
  var input;

  for(let i = 0; i < labels.length; i++){
    input = document.createElement('input');
    input.classList.add('input-search');
    input.id = labels[i];
    input.placeholder = labels[i];
    input.type = 'text';
    input.addEventListener('input',reloadTable);
    div.appendChild(input);
  }
  input = document.createElement('input');
  input.type = 'submit';
  input.value = 'Limpiar filtros';
  input.classList.add('button-clean');
  input.addEventListener('click',limpiarFiltros);
  div.appendChild(input);
  container.insertBefore(div,table);

}
function reloadTable(){
  clearTimeout(timeout);
  timeout = setTimeout(doFilters , 1000);
}
function doFilters(){

  var filters = {};
  filters.codigo = document.getElementById('codigo').value;
  filters.id  = document.getElementById('id').value;
  filters.descripcion  = document.getElementById('descripcion').value;
  filters.estado  = document.getElementById('estado').value;
  filters.precio_costo  = document.getElementById('precio costo').value;
  filters.precio_venta  = document.getElementById('precio venta').value;
  filters.talle  = document.getElementById('talle').value;
  filters.stock  = document.getElementById('stock').value;
  stockFiltrado = stock.filter(s =>
    ((s.codigo.toString().toLowerCase().includes(filters.codigo.toString().toLowerCase()) || filters.codigo == '') &&
    (s.id.toString().toLowerCase().includes(filters.id.toString().toLowerCase()) || filters.id == '') &&
    (s.descripcion.toString().toLowerCase().includes(filters.descripcion.toString().toLowerCase()) || filters.descripcion == '') &&
    (s.precio_costo.toString().toLowerCase().includes(filters.precio_costo.toString().toLowerCase()) || filters.precio_costo == '') &&
    (s.precio_venta.toString().toLowerCase().includes(filters.precio_venta.toString().toLowerCase()) || filters.precio_venta == '') &&
    (s.talle_id.toString().toLowerCase().includes(filters.talle.toString().toLowerCase()) || filters.talle == '') &&
    (s.stock.toString().toLowerCase().includes(filters.stock.toString().toLowerCase()) || filters.stock == '') &&
    (s.estado.toString().toLowerCase().includes(filters.estado.toString().toLowerCase()) || filters.estado == ''))
  );
  regenerateTable();

}

function regenerateTable(){

  var tbody = document.querySelector('table.table tbody'), tr, td;;
  tbody.innerHTML = '';

    for(let i = 0; i< stockFiltrado.length;i++){
      tr = document.createElement('tr');
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].descripcion;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].estado;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].codigo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].precio_costo;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].precio_venta;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].talle_id;
      tr.appendChild(td);
      td = document.createElement('td');
      td.innerHTML = stockFiltrado[i].stock;
      tr.appendChild(td);
      tbody.appendChild(tr);
    }

}

function limpiarFiltros(){
  document.getElementById('codigo').value = '';
  document.getElementById('id').value = '';
  document.getElementById('descripcion').value = '';
  document.getElementById('estado').value = '';
  document.getElementById('precio costo').value = '';
  document.getElementById('precio venta').value = '';
  document.getElementById('talle').value = '';
  document.getElementById('stock').value = '';

  stockFiltrado = stock;
  regenerateTable();
}
