<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "encuesta";

    // Nombre del archivo de respaldo
    $backupFileName = $database . "_" . date("Y-m-d-H-i-s") . ".sql";

    // Ruta a la carpeta de descargas del usuario
    $user = getenv("USERNAME");
    $backupFile = "C:\\Users\\$user\\Downloads\\" . $backupFileName;

    // Ruta completa al ejecutable mysqldump
    $mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe";

    // Comando mysqldump
    $command = "$mysqldumpPath --host=$host --user=$username --password=$password $database > $backupFile";

    // Ejecutar el comando y capturar la salida y errores
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }
?>