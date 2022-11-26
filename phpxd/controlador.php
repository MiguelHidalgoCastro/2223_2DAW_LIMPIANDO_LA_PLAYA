<?php
include("modelo.php");

if(isset($_POST['nombre']) && !empty($_POST['nombre']) &&
         isset($_POST['pass']) && !empty($_POST['pass'])){
	
    $nombre = $_POST['nombre'];
    $pass = $_POST['pass'];

    $object = new Modelo();

    if($object->validarUsuario($nombre , $pass)){
		header("Location:home.php");
	}
	else
	{
		echo "<h1>Eres malisimo</h1>";
		include ("loginadmin.php");
	}
}
else
{
	echo "<h1>Debes introducir el usuario y la contraseña</h1>";
	include ("loginadmin.php");
}

?>