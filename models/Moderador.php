<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Moderador{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$cedula,$telefono,$direccion,$correo,$clave){
	$sql="INSERT INTO moderador (nombre,cedula,telefono,direccion,correo,clave) VALUES ('$nombre','$cedula','$telefono','$direccion','$correo','$clave')";
	return ejecutarConsulta($sql);
}

public function editar($idmoderador,$nombre,$cedula,$telefono,$direccion,$correo){
	$sql="UPDATE moderador SET nombre='$nombre',cedula='$cedula',telefono='$telefono',direccion='$direccion',correo='$correo' 
	WHERE idmoderador='$idmoderador'";
	return ejecutarConsulta($sql);
}
public function desactivar($idusuario){
	$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}
public function activar($idusuario){
	$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
	return ejecutarConsulta($sql);
}

public function eliminar($idmoderador){
	$sql="DELETE FROM moderador WHERE idmoderador='$idmoderador'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idmoderador){
	$sql="SELECT * FROM moderador WHERE idmoderador='$idmoderador'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM moderador";
	return ejecutarConsulta($sql);
}

//funcion que verifica el acceso al sistema

public function verificar($correo,$clave){

	$sql="SELECT * FROM moderador WHERE correo='$correo' AND clave='$clave'";
	 return ejecutarConsulta($sql);

}
}

 ?>
