<?php
	require_once('conexion.php');
	include('../php/modelos/modelo.php');
 
 if ( isset($_POST['usuario']) && !empty($_POST['usuario']) &&
 isset($_POST['password']) && !empty($_POST['password'])){
		
	$nombre = $_POST['usuario'];
	$pass = $_POST['password'];
	$perfil= 'LP';
	$hass = password_hash($pass, PASSWORD_DEFAULT);
		
		$consulta = $mysqli->prepare ("INSERT INTO Administrador (nombre,clave,perfil) VALUES (?,?,?)");
		$consulta->bind_param('sss',$nombre,$hass,$perfil);
		$consulta->execute();
		$mysqli->close();
		
		unlink('adminalta.php');
		unlink('alta_usuario.html');
		unlink('conexion.php');
		$fichero= '../instalacion';
		$objeto = new Modelo();
		$objeto->borrarFichero($fichero);
	 }
        header("Location:../php/vistas/inicio_sesion.html");
?>   