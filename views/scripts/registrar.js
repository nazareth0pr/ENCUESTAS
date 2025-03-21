$("#registerForm").on("submit", function(e) {
    e.preventDefault();
    var clave = $("#claveRegister").val();
    var claveDos = $("#claveDosRegister").val();
    console.log(clave+claveDos);

    if(clave === claveDos){
        $.ajax({
            url: "../controllers/usuarios.php?op=guardaryeditar",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                console.log("Formulario enviado con éxito");
                alert(response);
                console.log(response);
                setTimeout(function() {
                    window.location.href = "./index.php";
                }, 2000);
                // Puedes manejar la respuesta aquí
            },
            error: function (xhr, status, error) {
                alert("Error al enviar el formulario: " + error)
                console.error("Error al enviar el formulario: " + error);
            }
        });
    }else{
        alert("Las contraseñas deben ser iguales");
    }
})
