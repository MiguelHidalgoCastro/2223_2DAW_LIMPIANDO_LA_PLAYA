<?php
   session_start(); 
   if(isset($_POST['cerrarSesion']) || !$_SESSION){
	session_destroy();
	header('Location: loginadmin.php');
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
    <h1>Bienvenido</h1>
  
	<form action="" method="POST">
		<input type="submit" value="cerrarSesion" name="cerrarSesion">
	</form>
   
</body>
</html>

  