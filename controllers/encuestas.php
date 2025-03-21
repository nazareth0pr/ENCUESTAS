<?php
require_once "../models/Encuestas.php";

$encuesta = new Encuestas();

$idEncuesta = isset($_POST["idEncuesta"]) ? limpiarCadena($_POST["idEncuesta"]) : "";
$encuestaInput = isset($_POST["encuestaInput"]) ? limpiarCadena($_POST["encuestaInput"]) : "";
$InicialFecha = isset($_POST["InicialFecha"]) ? limpiarCadena($_POST["InicialFecha"]) : "";
$cierreFecha = isset($_POST["cierreFecha"]) ? limpiarCadena($_POST["cierreFecha"]) : "";
$descripcionInput = isset($_POST["descripcionInput"]) ? limpiarCadena($_POST["descripcionInput"]) : "";
$idEncuestaEli = isset($_POST["idEncuestaEli"]) ? limpiarCadena($_POST["idEncuestaEli"]) : "";
$idEncuestaEdi = isset($_POST["idEncuestaEdi"]) ? limpiarCadena($_POST["idEncuestaEdi"]) : "";

$date = new DateTime();
$fecha = $date->format('Y-m-d');

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idEncuesta)) {
			$rspta = $encuesta->insertar($encuestaInput, $InicialFecha, $cierreFecha, $descripcionInput);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
			$rspta = $encuesta->editar($idEncuesta, $encuestaInput, $InicialFecha, $cierreFecha, $descripcionInput);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;
	case 'eliminar':
		$rspta = $encuesta->eliminar($idEncuestaEli);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;

	case 'desactivar':
		$rspta = $encuesta->desactivar($idEncuestaEli);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta = $encuesta->activar($idEncuestaEli);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $encuesta->mostrar($idEncuestaEdi);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $encuesta->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idencuesta,
				"1" => $reg->nombre,
				"2" => $reg->descripcion,
				"3" => $reg->fecha_inicio,
				"4" => $reg->fecha_final,
				"5" => $reg->fecha_registro,
				"6" => '<div>
							<a href="#" onclick="editar(' . $reg->idencuesta . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-pencil-fill"></i></a>
							<a href="#" onclick="eliminar(' . $reg->idencuesta . ')" class="btn btn-primary btn-circle btn-sm"><i class="bi bi-trash3-fill"></i></a>
						</div>'
			);
		}
		$results = array(
			"aaData" => $data
		);
		echo json_encode($results);
		break;
}
