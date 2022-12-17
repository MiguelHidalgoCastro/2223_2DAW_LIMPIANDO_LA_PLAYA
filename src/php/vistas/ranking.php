<?php
	/*Recuerda la sesión*/
	include('../controladores/controladorranking.php');
	
	$controlador = new Controlador();
	$datos = $controlador->datosRanking();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="Miguel Hidalgo Catro 2DAW 22/23" />
		<link rel="shortcut icon" href="../../img/logo/logoicon.png">
		<title>RANKING</title>
		<link rel="stylesheet" href="../../css/style.css">
	</head>
	<body>
		<header class="header">
			<div class="logo">
				<img src="../../img/logo/logodefinitivo1.png" alt="Logo Limpiemos La Playa" id="logo" />
			</div>
			<nav>
				<input type="checkbox" id="check">
				<label for="check" id="btnMenu">
					<img src="../../img/iconos/menu.png" alt="Icono de menú"/>
				</label>
				<ul class="nav-links">
					<li><a href="../../index.php">Juego</a></li>
					<li><a href="ranking.php">Ranking</a></li>
				</ul>
			</nav>
		</header>
		<main>
			<div id="tablaRanking">
				<table>
					<thead>
						<tr>
							<th>Alias</th>
							<th>Puntuación</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($datos as $dato){ //Una vez que recorre la primera fila y la mete en un array, el puntero apunta al siguiente.
							echo "<tr>
									<td>".$dato["alias"]."</td>
									<td>".$dato["puntos"]."</td>
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
				<a target="_blank" title="Twitter" href=""><img class="rrss" alt="Icono red social Twitter" src= "../../img/rrss/twitternar1.png"></a>
				<a target="_blank" title="Facebook" href=""><img class="rrss" alt="Icono red social Facebook" src= "../../img/rrss/facebooknar1.png"></a>
				<a target="_blank" title="Instagram" href=""><img class="rrss" alt="Icono red social Instagram" src= "../../img/rrss/instagramnar1.png"></a>
				<a target="_blank" title="LinkedIn" href=""><img class="rrss" alt="Icono red social LinkedIn" src= "../../img/rrss/linkedinnar1.png"></a>
			</div>
		</footer>
	</body>
</html>