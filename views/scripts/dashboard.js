$("#cerrarSesionBtn").on("click", function(){
    $.post("../controllers/usuarios.php?op=salir", function(data){
        alert("Sesion finalizada");
		setTimeout(function() {
			window.location.href = "../index.php";
		}, 2000);
    });
});