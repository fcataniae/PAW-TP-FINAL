var window = window || {},
    document = document || {},
    console = console || {};

var filterUrl ;
var callbackFn ;
var errorCalbackFn ;
var filters ;

callbackFn = function printTable(res){
  res = JSON.parse(res);
  destroyTabla();
  encabezados = res.columnas;
  registrosFiltrados = res.registros;
  registros = res.registros;
  construirTabla(encabezados, registros);
  paginarAndVisualizarRegistros(REGISTROS_POR_PAGINA, PAGINA_INICIAL);
}

errorCalbackFn = function showError(res,stat){
  console.log(res);
  console.log(stat);
}

const CONTAINER = 'div#filters';
const INPUT_TYPE = 'input';
const DATALIST_TYPE = 'datalist';
const MULTI_INPUT_TYPE = 'multi-input';
const INPUT_DATALIST = 'input+datalist';
const STATIC = 'static';
const DINAMIC = 'dinamic';
const DATE_BETWEEN = 'date-between';
const DATALIST_PREFIX = 'datalist_';
const HTTP_GET = 'GET'
const DATE_TYPE = 'date';
const TEXT_TYPE = 'text';
const PARAMS_QUERY = 'input.form-input';
/*
  [
    {
      "type" : "input"
      "dataType" : "text"
      "description" : "Placeholder"
      "queryParam" : "id"
    },
    {
      "type" : "input"
      "dataType" : "number"
      "description" : "Placeholder"
      "queryParam" : "id"
      "min" : 0
    },
    {
      "type" : "input"
      "dataType" : "date-between"
      "min" : 0
      "objects" : [
        {
          "description" : "Placeholder"
          "queryParam" : "id"
        },
        {
          "description" : "Placeholder"
          "queryParam" : "id"
        }

      ]
    },
    {
      "type" : "input+datalist"
      "dataType" : "dinamic"
      "description" : "Placeholder"
      "queryParam" : "id"
      "datalistUrl" : "url"
    },
    {
      "type" : "input+datalist"
      "dataType" : "static"
      "description" : "Placeholder"
      "queryParam" : "id"
      "datalistData" : [
        { 
          "id" : ""
          "descripcion": ""
        }
      ]
    }
  ]
*/

function drawFilters(){

  filters = JSON.parse(filters);
  filters.forEach( f => {

    switch(f.type) {
      case INPUT_DATALIST : 
        drawDatalist(f);
      break;
      case INPUT_TYPE :
        drawInput(f);
      break;
      case MULTI_INPUT_TYPE:
        drawMultiInput(f);
      break;
      default: console.log(f);
    } 

  });
  addFilterButton();
}

function addFilterButton(){

  let container = document.querySelector(CONTAINER);
  let button = document.createElement("button");
  let div = document.createElement("div");
  div.classList.add("filter-group");
  container.appendChild(div);
  button.addEventListener('click', doSearch);
  button.innerText = "Buscar";
  button.classList.add("button");
  button.classList.add("btn-form");
  button.classList.add("btn-azul");
  div.appendChild(button);
}
function doSearch(){
  let params = [];
  let filters = document.querySelectorAll(PARAMS_QUERY);
  filters.forEach( filter => {
    let value = filter.value;
    if(value && value.trim() != ''){
      let param = {
        'query' : filter.id,
        'value' : value
      };
      params.push(param);
  }
  });
  
  ajaxCallWParameters(HTTP_GET, filterUrl , params, callbackFn, errorCalbackFn);
}


function drawDatalist(filter){

  switch(filter.dataType){

    case DINAMIC:
      drawDinamicDatalist(filter);
    break;
    case STATIC:
      drawStaticDatalist(filter);
    break;
    default: console.log(filter);
  }

}

function drawDinamicDatalist(filter ){

  let container = document.querySelector(CONTAINER);
  let div = document.createElement("div");
  div.classList.add("filter-group");
  container.appendChild(div);
  let input = document.createElement(INPUT_TYPE);
  let datalist = document.createElement(DATALIST_TYPE);
  let label = document.createElement("label");
  label.setAttribute('for', filter.queryParam);
  label.innerText =  filter.description;
  label.classList.add('filter-label');
  input.classList.add('form-input');
  input.type = TEXT_TYPE;
  input.placeholder = filter.description;
  input.id = filter.queryParam;
  input.name = filter.queryParam;
  datalist.id = DATALIST_PREFIX + filter.queryParam;
  input.setAttribute('list' , datalist.id);
  div.appendChild(label);
  div.appendChild(datalist);
  ajaxCall(HTTP_GET, filter.datalistUrl, asyncCompleteDatalist(datalist.id));
  div.appendChild(input);
}

function drawStaticDatalist(filter){

  let container = document.querySelector(CONTAINER);
  let div = document.createElement("div");
  div.classList.add("filter-group");
  container.appendChild(div);
  let input = document.createElement(INPUT_TYPE);
  let datalist = document.createElement(DATALIST_TYPE);
  let label = document.createElement("label");
  label.setAttribute('for', filter.queryParam);
  label.innerText =  filter.description;
  label.classList.add('filter-label');
  input.classList.add('form-input');
  input.type = TEXT_TYPE;
  input.placeholder = filter.description;
  input.id = filter.queryParam;
  input.name = filter.queryParam;
  datalist.id = DATALIST_PREFIX + filter.queryParam;
  input.setAttribute('list' , datalist.id);
  div.appendChild(label);
  div.appendChild(datalist);
  completeDatalist(filter.datalistData, datalist.id);  
  div.appendChild(input);
}

function drawInput(filter){
  
  let container = document.querySelector(CONTAINER);
  let div = document.createElement("div");
  div.classList.add("filter-group");
  container.appendChild(div);
  let input = document.createElement(filter.type);
  let label = document.createElement("label");
  label.setAttribute('for', filter.queryParam);
  label.innerText =  filter.description;
  label.classList.add('filter-label');
  input.classList.add('form-input');
  input.type = filter.dataType;
  input.placeholder = filter.description;
  input.id = filter.queryParam;
  input.name = filter.queryParam;
  if(filter.min){
    input.min = filter.min;
  }
  div.appendChild(label);
  div.appendChild(input);
}

function drawMultiInput(filter){

  if(filter.dataType == DATE_BETWEEN){

    let container = document.querySelector(CONTAINER);
    filter.objects.forEach( f => {
      let input = document.createElement(INPUT_TYPE);
      let label = document.createElement("label");
      let div = document.createElement("div");
      div.classList.add("filter-group");
      container.appendChild(div);
      label.setAttribute('for', f.queryParam);
      label.innerText =  f.description;
      label.classList.add('filter-label');
      input.classList.add('form-input');
      input.type = DATE_TYPE;
      input.id = f.queryParam;
      input.name = f.queryParam;
      input.placeholder = f.description;
      div.appendChild(label);
      div.appendChild(input);
    });
  }
}

function asyncCompleteDatalist(datalist) {

  return res => { 
    return completeDatalist(JSON.parse(res) , datalist);
  };
}

function completeDatalist(data, datalist){

  let dlist = document.querySelector('datalist#' + datalist);
  let option;
  data.forEach(d => {
    option = document.createElement('option');
    option.value = d.id;
    option.innerHTML = d.descripcion;
    dlist.appendChild(option);
  });
}

