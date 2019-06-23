var window = window || {},
    document = document || {},
    console = console || {};

window.onload = onloadwindow;

function onloadwindow(){
  controls();
  sidenav();
}

function controls(){
  var negocio = document.querySelector('ul.main-nav li.negocio');
  var venta = document.querySelector('ul.main-nav li.venta');
  var inventario = document.querySelector('ul.main-nav li.inventario');
  if(negocio){
    negocio.addEventListener('click',sidenavNegocio);
  }
  if(venta){
    venta.addEventListener('click',sidenavVenta);
  }
  if(inventario){
    inventario.addEventListener('click',sidenavInventario);
  }
}
function sidenav(){

 let expands = document.querySelectorAll('nav.sidenav span.expand');
 console.log(expands);
 expands.forEach( expand =>{
   expand.addEventListener('click', function(){
     let sidenavul = document.querySelector('nav.sidenav.open ul.show');
     let sidenav = document.querySelector('nav.sidenav.open.sidenav-200');
     if(!sidenav || !sidenavul){

       sidenavul = document.querySelector('nav.sidenav.open ul');
       sidenav = document.querySelector('nav.sidenav.open');
       sidenavul.classList.add('show');
       sidenav.classList.add('sidenav-200');
       sidenavul.classList.remove('unshow');
     }else{
       sidenavul = document.querySelector('nav.sidenav.open ul');
       sidenav = document.querySelector('nav.sidenav.open');
       sidenavul.classList.add('unshow');
       sidenav.classList.remove('sidenav-200');
       sidenavul.classList.remove('show');
     }
   });
  });
}

function sidenavInventario(){
  let sidenav = document.querySelector('nav.sidenav.inventario.close');

  if(!sidenav){
    sidenav = document.querySelector('nav.sidenav.inventario');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    sidenav.classList.remove('close');
    sidenav.classList.add('open');
  }
}
function sidenavNegocio(){
  let sidenav = document.querySelector('nav.sidenav.negocio.close');

  if(!sidenav){
    sidenav = document.querySelector('nav.sidenav.negocio');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    sidenav.classList.remove('close');
    sidenav.classList.add('open');
  }
}
function sidenavNegocio(){
  let sidenav = document.querySelector('nav.sidenav.venta.close');

  if(!sidenav){
    sidenav = document.querySelector('nav.sidenav.venta');
    sidenav.classList.remove('open');
    sidenav.classList.add('close');
  }else{
    sidenav.classList.remove('close');
    sidenav.classList.add('open');
  }
}
