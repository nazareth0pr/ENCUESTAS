$("#loginForm").on("submit", function (e) {
    e.preventDefault();
    correoLogin = $("#correoLogin").val();
    ClaveLogin = $("#ClaveLogin").val();


    $.post("../controllers/moderador.php?op=verificar",
        { "correoLogin": correoLogin, "ClaveLogin": ClaveLogin },
        function (data) {
            console.log(data);
            if (data === 'success') {
                alert('Sesion iniciada');
                setTimeout(function () {
                    window.location.href = "./dashboard.php";
                }, 3000);
            } else {
                console.log(data);
                alert('Usuario o contraseña incorrectos');
            }
        });

})

$("#cerrarSesionBtn").on("click", function(){
    $.post("../controllers/usuarios.php?op=salir", function(data){
        alert("Sesion finalizada");
		setTimeout(function() {
			window.location.href = "../index.php";
		}, 2000);
    });
});