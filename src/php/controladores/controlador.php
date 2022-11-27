<?php
	include("../modelos/modelo.php");

	if(isset($_POST['nombre']) && !empty($_POST['nombre']) &&
			 isset($_POST['pass']) && !empty($_POST['pass'])){
		
		$nombre = $_POST['nombre'];
		$pass = $_POST['pass'];

		$object = new Modelo();

		if($object->validarUsuario($nombre , $pass)){
			header("Location:../vistas/inicio_admin.php");
		}
		else
		{
			echo "<h1>Login incorrecto</h1>";
			include ("../vistas/inicio_sesion.html");
		}
	}
	else
	{
		echo "<h1>Debes introducir el usuario y la contraseña</h1>";
		include ("../vistas/inicio_sesion.html");
	}
?>