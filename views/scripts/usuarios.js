listar();

function listar(){
	tabla=$('#dataTable').dataTable({
		"language": {
			 "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" 
		},
		scrollX: true,
		"ajax":
		{
			url:'../controllers/usuarios.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true
	}).DataTable();
}

$("#backupBtn").on("click", function(){
    $.post("../controllers/backup.php", function(data){
        data = JSON.parse(data);
        console.log(data);
        data == true ? alert("Respaldo realizado con exito") : alert("Error al realizar el respaldo");
    });
});

$("#cerrarSesionBtn").on("click", function(){
    $.post("../controllers/usuarios.php?op=salir", function(data){
        alert("Sesion finalizada");
		setTimeout(function() {
			window.location.href = "../index.php";
		}, 2000);
    });
});