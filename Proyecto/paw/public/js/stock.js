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

  container.insertBefore(div,table);

}
function reloadTable(){
  clearTimeout(timeout);
  timeout = setTimeout(doFilters , 2000);
}
function doFilters(){

}
