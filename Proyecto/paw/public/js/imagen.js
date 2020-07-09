document.addEventListener("DOMContentLoaded", function () {
	var imagen_load = document.getElementById("imagen_load");
	imagen_load.onchange = function(){
		readURL(this);
	};
	
	var imagen_eliminar = document.getElementById("imagen_eliminar");
	imagen_eliminar.onclick = function() {
		document.getElementById("imagen_usuario").src = document.getElementById("img_default").value; 
		document.getElementById("imagen_load").value = null;
		document.getElementById("imagen_cambiada").value = 1;
    };
});

function readURL(input) {
	if (input.files && input.files[0]) {
		if (input.files[0].size > 512000) {
            document.querySelector("div.error-imagen").style.display = "inline";
			document.getElementById("imagen_load").value = null;
			document.getElementById("imagen_cambiada").value = 0;
		}else {
			document.querySelector("div.error-imagen").style.display = "none";
			document.getElementById("imagen_cambiada").value = 1;
            var reader = new FileReader();
            reader.onload = function(e) {
				document.getElementById("imagen_usuario").src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
}