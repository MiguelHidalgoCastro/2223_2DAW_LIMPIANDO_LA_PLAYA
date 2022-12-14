<?php
    /*Para recordar la sesión del administrador */
    session_start();

    if (isset($_POST['cerrarSesion']) || !$_SESSION) {
        session_destroy();
        header('Location: inicio_sesion.html');
    }

    include('../controladores/controlador_torres.php');

    $controlador = new Controlador();
    $datos = $controlador->datosTorres();   
	
	if(isset($_GET['variable2']))
	{
		$controlador-> borrarTorres($_GET["variable1"]);
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
		<title>Gestion de torres</title>
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
					<li><a id="resalto" href="listartorres.php">Defensas</a></li>
					<li><a href="listarenemigos.php">Enemigos</a></li>
					<li>
						<form action="" method="POST">
							<input class="btn" type="submit" name="cerrarSesion" value="Cerrar Sesión" />
						</form>
					</li>
				</ul>
			</nav>
		</header><br>
		<main>
			<div id="divEnemigos">
				<h1>Listado de torres</h1><br>
				<table id="tableEnemigos">               
					<tr>
						<th>Nombre</th>
						<th>Radio de actuación</th>
						<th>Velocidad de recorrido</th>
						<th>Nombre img</th>
						<th>Procesos</th>
					</tr>
					<!--
					<tr>
						<td>Pescador solitario</td>
						<td>150</td>
						<td>20 seg</td>
						<td>Nose</td>
						<td><a href="modificar_torre.php"><img src="../../img/iconos/edit.png"></a> <a href="gestion_torres.php"><img src="../../img/iconos/delete.png"></a></td>
					</tr>
					-->
					<?php
						if($datos)
						{
							foreach($datos as $dato)
							{
								echo '<tr>
										<td>'.$dato["nombre"].'</td>
										<td>'.$dato["radioActuacion"].'</td>
										<td>'.$dato["velocidadRecorrido"].'</td>
										<td><img class="imgTabla" src="'.$dato["nombreImagen"].'"</td>
										<td><a onSubmit="return confirm(¿Está seguro de querer borrar la torre?.)" href=listartorres.php?variable1='.$dato["id"].'&variable2=borrar><img src=../../img/iconos/delete.png title="borrar"></a>
										<a href=modificartorres.php?variable1='.$dato["id"].'><img src=../../img/iconos/edit.png title="modificar"></a>
									</td></tr>';
							}
						}
					?>
					<!--
					<tr>
						<td>Pescador duo</td>
						<td>3 obj por seg</td>
						<td>35</td>
						<td>Nose</td>
						<td><img src=""><img src=""></td>
					</tr>
					<tr>
						<td>Pescador triple</td>
						<td>5 obj por seg</td>
						<td>50</td>
						<td>Nose</td>
						<td><img src=""><img src=""></td>
					</tr>
					-->
				</table><br>
				<a href="anadirtorres.php"><input type="submit" value="AÑADIR TORRE"></a><br>
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