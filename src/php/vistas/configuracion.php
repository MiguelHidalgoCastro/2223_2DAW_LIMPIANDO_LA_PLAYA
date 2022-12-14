<?php
	/*Recuerda la sesión*/
	session_start();
	if (isset($_POST['cerrarSesion']) || !$_SESSION) {
		session_destroy();
		header('Location: inicio_sesion.php');
	}
	
	include('../controladores/controlador.php');
	
	$controlador = new Controlador();
	
	$vacio = false; /*Variable para mostrar alert o no, controla si algún campo está vacío.*/

	$datos = $controlador->datosConfiguracion();
	
	if(isset($_POST) && !empty($_POST)){
		$vacio=$controlador->modificarConfiguracion($_POST);
	}
	
	if($vacio){
		/*echo '<script>alert("Todos los campos han de estar rellenados")</script>';*/
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
		<title>Configuración</title>
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
					<li><a id="resalto" href="configuracion.php">Configuración</a></li>
					<li><a href="listaescenarios.php">Escenarios</a></li>
					<li><a href="listartorres.php">Defensas</a></li>
					<li><a href="listarenemigos.php">Enemigos</a></li>
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
				<h2>AJUSTAR CONFIGURACION</h2><br>
				<form action="" id="formConfiguracion" method="POST" >
					<?php		
						echo	'<label>Ruta torre <input value="'.$datos["rutaTorre"].'" type="text" name="rutaDefensa"></label> 
								<input value="'.$datos["rutaEnemigo"].'" type="text" name="rutaEnemigo" class="rutar"> <label for="rutaEnemigo" class="rutar">Ruta enemigo</label><br>
								<label class="centro">Ruta escenario <input value="'.$datos["rutaEscenario"].'" type="text" name="rutaEscenario" class="centro"></label><br><br><hr><br>
								<h4>Medidas de la ventana</h4><br>
								<label for="dimensiones" class="alto">Dimensiones de la pantalla de juego</label><br><br>
								<input readonly type="text" name="medVentana" value="'.$datos["medidaVentanaJuego"].'" class=alto><br>
								<div id="divEmergente">La dimensión de la ventana no pueden modificarse</div><br><hr><br>
								<h4>Filas de la tabla ranking</h4><br>
								<label class="centro">Jugadores que aparecerán en el ranking <input type="number" value="'.$datos["filasRanking"].'" name="numFilas"></label><br><br>';
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
		<script type=module src="../../js/vistas/validaciones.js"></script>
	</body>
</html>