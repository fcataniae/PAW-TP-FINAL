var window = window || {},
    document = document || {},
    console = console || {};

window.onload = sidenav;

function sidenav(){

 let expand = document.querySelector('nav.sidenav span.expand');
 console.log(expand);
 expand.addEventListener("click", function(){
   let sidenavul = document.querySelector('nav.sidenav ul.show');
   let sidenav = document.querySelector('nav.sidenav.sidenav-200');
   console.log(sidenav);
   console.log(sidenavul);
   console.log("asdasd");
   if(!sidenav || !sidenavul){

     sidenavul = document.querySelector('nav.sidenav ul');
     sidenav = document.querySelector('nav.sidenav');
     console.log(sidenav);
     console.log(sidenavul);
     sidenavul.classList.add('show');
     sidenav.classList.add('sidenav-200');
     sidenavul.classList.remove('unshow');
   }else{
     sidenavul = document.querySelector('nav.sidenav ul');
     sidenav = document.querySelector('nav.sidenav');
     sidenavul.classList.add('unshow');
     sidenav.classList.remove('sidenav-200');
     sidenavul.classList.remove('show');
   }
 });
}
