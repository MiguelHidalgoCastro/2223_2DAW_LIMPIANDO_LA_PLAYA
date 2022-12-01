<?php
	/*Recuerda la sesión*/
	session_start();
	if (isset($_POST['cerrarSesion']) || !$_SESSION) {
		session_destroy();
		header('Location: inicio_sesion.html');
	}
	
	include('../controladores/controlador.php');
	
	$vacio = false; /*Variable para mostrar alert o no, controla si algún campo está vacío.*/
	
	$controlador = new Controlador();
	
	$id=$_GET["variable1"];
	
	$datos = $controlador->datosEnemigoModificar($id);
	var_dump($datos[0]["nombreImagen"]);
	if(isset($_POST) && !empty($_POST)){
		$vacio=$controlador->modificarEnemigo($_POST, $_FILES ,$datos[0]["nombreImagen"], $id);
	}
	
	if($vacio){
		echo '<script>alert("Todos los campos han de estar rellenados")</script>';
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Grupo Limpiemos La Playa 2DAW 22/23" />
		<link rel="shortcut icon" href="../../img/logo/logoicon.png">
		<link rel="stylesheet" href="../../css/style.css">
		<title>Modificar Enemigos</title>
	</head>
	<body>
		<header class="header">
			<div class="logo">
				<img src="../../img/logo/logodefinitivo1.png" alt="Logo Limpiemos La Playa" id="logo" />
			</div>
			<nav>
				<input type="checkbox" id="check" />
				<label for="check" id="btnMenu">
					<img src="../../img/iconos/menu.png" alt="Icono de menú" />
				</label>
				<ul class="nav-links">
					<li><a href="inicio_admin.php">Inicio</a></li>
					<li><a href="configuracion.php">Configuración</a></li>
					<li><a href="#">Escenarios</a></li>
					<li><a href="#">Defensas</a></li>
					<li><a id="resalto" href="listarenemigos.php">Enemigos</a></li>
					<li>
						<form action="" method="POST">
							<input class="btn" type="submit" name="cerrarSesion" value="Cerrar Sesión" />
						</form>
					</li>
				</ul>
			</nav>
		</header>
		<main>
			<div id="divConfiguracion">
				<form enctype="multipart/form-data" action="" id="formularioModificarEnemigo" method="POST" onSubmit="return confirm('¿Está seguro de querer modificar este enemigo?.')">
					<h2>Modificación</h2>
					<label for="nombre">Nombre enemigo</label>
					<?php
						echo 	'<input value="'.$datos[0]["nombre"].'" type="text" name="nombre"/>
								<label for="velocidadMov">Velocidad movimiento</label>
								<input value="'.$datos[0]["velocidadMov"].'" type="text" name="velocidadMov"/>
								<label for="puntos">Puntos</label>
								<input value="'.$datos[0]["puntos"].'" type="text" name="puntos"/>
								<label for="nombreImagen">Nombre de la imagen</label>
								<img height="100px width="100px"" src = "'.$datos[0]["nombreImagen"].'"/>
								<input type="file" name="nombreImagen"/>';
					?>
					<input type="submit" value="Modificar"/>
				</form>
			</div>
		</main>
		<footer>
			<div id="copy">
				<p>© Fundación Loyola 2022</p>
			</div>
			<div id="avisos">
				<p>Aviso legal</p>
			</div>
			<div id="cookies">
				<p>Cookies</p>
			</div>
			<div id="rrss">
				<a target="_blank" title="Twitter" href=""><img class="rrss" alt="Icono red social Twitter" src="../../img/rrss/twitternar1.png"></a>
				<a target="_blank" title="Facebook" href=""><img class="rrss" alt="Icono red social Facebook" src="../../img/rrss/facebooknar1.png"></a>
				<a target="_blank" title="Instagram" href=""><img class="rrss" alt="Icono red social Instagram" src="../../img/rrss/instagramnar1.png"></a>
				<a target="_blank" title="LinkedIn" href=""><img class="rrss" alt="Icono red social LinkedIn" src="../../img/rrss/linkedinnar1.png"></a>
			</div>
		</footer>
	</body>
</html>