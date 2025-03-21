<?php
session_start();
require_once "../models/Usuarios.php";

$usuario = new Usuarios();

$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombreRegister = isset($_POST["nombreRegister"]) ? limpiarCadena($_POST["nombreRegister"]) : "";
$correoRegister = isset($_POST["correoRegister"]) ? limpiarCadena($_POST["correoRegister"]) : "";
$claveRegister = isset($_POST["claveRegister"]) ? limpiarCadena($_POST["claveRegister"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		//Hash SHA256 para la contraseña
		$clavehash = hash("SHA256", $claveRegister);
		if (empty($idusuario)) {
			$rspta = $usuario->insertar($nombreRegister, $correoRegister, $clavehash);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario";
		} else {
			$rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $_POST['permiso']);
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

	case 'mostrar':
		$rspta = $usuario->mostrar($idusuario);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $usuario->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idusuario,
				"1" => $reg->nombre,
				"2" => $reg->correo,
				"3" => '<div>
							<a href="#" onclick="editar(' . $reg->idusuario . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-eye-fill"></i></a>
							<a href="#" onclick="eliminar(' . $reg->idusuario . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-ban"></i></a>
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

		$rspta = $usuario->verificar($correoLogin, $ClaveLogin);

		$fetch = $rspta->fetch_object();

		if (isset($fetch)) {
			# Declaramos la variables de sesion
			$_SESSION['idmoderador'] = $fetch->idmoderador;
			$_SESSION['nombre'] = $fetch->nombre;
			$_SESSION['cedula'] = $fetch->cedula;
			$_SESSION['telefono'] = $fetch->telefono;
			$_SESSION['direccion'] = $fetch->direccion;
			$_SESSION['correo'] = $fetch->correo;
		}

		echo empty($fetch) ? "failure" : "success";
		break;

	case 'salir':
		//limpiamos la variables de la secion
		session_unset();

		//destruimos la sesion
		session_destroy();
		//redireccionamos al login
		break;
}
