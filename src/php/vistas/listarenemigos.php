<?php
	/*Recuerda la sesión*/
	session_start();
	if (isset($_POST['cerrarSesion']) || !$_SESSION) {
		session_destroy();
		header('Location: inicio_sesion.html');
	}
	
	include('../controladores/controlador.php');
	
	$controlador = new Controlador();
	$datos = $controlador->datosEnemigos();
	
	if(isset($_GET['variable2'])){
		$controlador->borrarEnemigo($_GET["variable1"]);
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
		<title>Enemigos</title>
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
					<li><a id="resalto" href="listarEnemigos.php">Enemigos</a></li>
					<li>
						<form action="" method="POST">
							<input class="btn" type="submit" name="cerrarSesion" value="Cerrar Sesión" />
						</form>
					</li>
				</ul>
			</nav>
		</header>
		<main>
			<button id="anadirenemigo"><a href="anadirenemigos.php">Añadir</a></button>
			<div id="divTablaEnemigos">
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Puntos</th>
							<th>Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($datos as $dato){ //Una vez que recorre la primera fila y la mete en un array, el puntero apunta al siguiente.
								echo "<tr>
										<td>".$dato["id"]."</td>
										<td>".$dato["nombre"]."</td>
										<td>".$dato["puntos"]."</td>
										<td>
											<a href=listarenemigos.php?variable1=".$dato["id"]."&variable2=borrar><img src=imagenes/delete.svg title='borrar'></a>
											<a href=modificarenemigos.php?variable1=".$dato["id"]."><img src=imagenes/edit.svg title='modificar'></a>
										</td>
									</tr>";
							}
						?>
					</tbody>
				</table>
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