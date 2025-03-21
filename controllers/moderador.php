<?php
session_start();
require_once "../models/Moderador.php";

$moderador = new Moderador();

$idModerador = isset($_POST["idModerador"]) ? limpiarCadena($_POST["idModerador"]) : "";
$nombreInput = isset($_POST["nombreInput"]) ? limpiarCadena($_POST["nombreInput"]) : "";
$cedulaInput = isset($_POST["cedulaInput"]) ? limpiarCadena($_POST["cedulaInput"]) : "";
$telefonoInput = isset($_POST["telefonoInput"]) ? limpiarCadena($_POST["telefonoInput"]) : "";
$correoInput = isset($_POST["correoInput"]) ? limpiarCadena($_POST["correoInput"]) : "";
$direccionInput = isset($_POST["direccionInput"]) ? limpiarCadena($_POST["direccionInput"]) : "";
$idModeradorEli = isset($_POST["idModeradorEli"]) ? limpiarCadena($_POST["idModeradorEli"]) : "";
$idModeradorEdi = isset($_POST["idModeradorEdi"]) ? limpiarCadena($_POST["idModeradorEdi"]) : "";
$claveInput = isset($_POST["claveInput"]) ? limpiarCadena($_POST["claveInput"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		//Hash SHA256 para la contraseña
		$clavehash = hash("SHA256", $claveInput);
		if (empty($idModerador)) {
			$rspta = $moderador->insertar($nombreInput, $cedulaInput, $telefonoInput, $direccionInput, $correoInput, $clavehash);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario";
		} else {
			$rspta = $moderador->editar($idModerador, $nombreInput, $cedulaInput, $telefonoInput, $direccionInput, $correoInput);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;


	case 'desactivar':
		$rspta = $usuario->desactivar($idusuario);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar':
		$rspta = $usuario->activar($idusuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'eliminar':
		$rspta = $moderador->eliminar($idModeradorEli);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;

	case 'mostrar':
		$rspta = $moderador->mostrar($idModeradorEdi);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $moderador->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idmoderador,
				"1" => $reg->nombre,
				"2" => $reg->cedula,
				"3" => $reg->telefono,
				"4" => $reg->direccion,
				"5" => $reg->correo,
				"6" => '<div>
							<a href="#" onclick="editar(' . $reg->idmoderador . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-pencil-fill"></i></a>
							<a href="#" onclick="eliminar(' . $reg->idmoderador . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-trash3-fill"></i></a>
						</div>'
			);
		}

		$results = array(
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'verificar':
		//validar si el usuario tiene acceso al sistema
		$correoLogin = $_POST['correoLogin'];
		$ClaveLogin = $_POST['ClaveLogin'];

		//Hash SHA256 en la contraseña
		//$clavehash = hash("SHA256", $clavea);

		$rspta = $moderador->verificar($correoLogin, $ClaveLogin);

		$fetch = $rspta->fetch_object();

		# Declaramos la variables de sesion
		$_SESSION['idmoderador'] = $fetch->idmoderador;
		$_SESSION['nombre'] = $fetch->nombre;
		$_SESSION['cedula'] = $fetch->cedula;
		$_SESSION['telefono'] = $fetch->telefono;
		$_SESSION['direccion'] = $fetch->direccion;
		$_SESSION['correo'] = $fetch->correo;
		
		echo empty($fetch) ? "failure" : "success";
		break;


		break;
	case 'salir':
		//limpiamos la variables de la secion
		session_unset();

		//destruimos la sesion
		session_destroy();
		//redireccionamos al login
		header("Location: ../index.php");
		break;
}
