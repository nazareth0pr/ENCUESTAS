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

listar();

$("#agregarForm").on("click", function() {
    $("#cardTable").hide();
    $("#cardForm").show();
})

$("#cancerlarBtn").on("click", function() {
    window.location.href = "./encuestas.php";
})

$("#formulario").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        url: "../controllers/encuestas.php?op=guardaryeditar",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            console.log("Formulario enviado con éxito");
            alert(response);
            console.log(response);
            setTimeout(function() {
                window.location.href = "./encuestas.php";
            }, 2000);
            // Puedes manejar la respuesta aquí
        },
        error: function (xhr, status, error) {
            alert("Error al enviar el formulario: " + error)
            console.error("Error al enviar el formulario: " + error);
        }
    });
});

function listar(){
	tabla=$('#dataTable').dataTable({
		"language": {
			 "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" 
		},
		scrollX: true,
		"ajax":
		{
			url:'../controllers/encuestas.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true
	}).DataTable();
}

function eliminar(idEncuestaEli){
    var confirmacion = confirm("¿Estás seguro de que deseas realizar esta acción?");

    if (confirmacion) {
            $.post("../controllers/encuestas.php?op=eliminar" , {idEncuestaEli : idEncuestaEli}, function(e){
                console.log(e);
				alert(e);
				setTimeout(function() {
                    window.location.href = "./encuestas.php";
                }, 2000);
			});
        }else {
            // El usuario hizo clic en "Cancelar"
            console.log("Acción cancelada.");
        }
}

function editar(idEncuestaEdi){
    $.post("../controllers/encuestas.php?op=mostrar",{idEncuestaEdi : idEncuestaEdi},
		function(data,status)
		{
            console.log(data);
			data=JSON.parse(data);
			$("#cardTable").hide();
            $("#cardForm").show();

            $("#idEncuesta").val(data.idencuesta);
            $("#encuestaInput").val(data.nombre);
            $("#InicialFecha").val(data.fecha_inicio);
            $("#cierreFecha").val(data.fecha_final);
            $("#descripcionInput").val(data.descripcion);
		})
}