<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Encuestas{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($encuestaInput,$InicialFecha,$cierreFecha,$descripcionInput){
	$sql="INSERT INTO encuesta (nombre,fecha_inicio,fecha_final,descripcion)
	 VALUES ('$encuestaInput','$InicialFecha','$cierreFecha','$descripcionInput')";
	return ejecutarConsulta($sql);
}

public function editar($idEncuesta,$encuestaInput,$InicialFecha,$cierreFecha,$descripcionInput){
	$sql="UPDATE encuesta SET nombre='$encuestaInput',fecha_inicio='$InicialFecha', fecha_final='$cierreFecha',descripcion='$descripcionInput'
	WHERE idencuesta ='$idEncuesta'";
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}

public function eliminar($idEncuestaEli){
	$sql = "DELETE FROM encuesta WHERE idencuesta='$idEncuestaEli'";
	return ejecutarConsulta($sql);
}

public function activar($idarticulo){
	$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idEncuestaEdi){
	$sql="SELECT * FROM encuesta WHERE idencuesta='$idEncuestaEdi'";
	return ejecutarConsultaSimpleFila($sql);
}

public function codigo(){
	$sql="SELECT CONCAT('PD', LPAD(FLOOR(RAND() * (9999 - 1000 + 1)) + 1000, 4, '0')) AS codigo;";
	return ejecutarConsulta($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT * FROM encuesta;";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
