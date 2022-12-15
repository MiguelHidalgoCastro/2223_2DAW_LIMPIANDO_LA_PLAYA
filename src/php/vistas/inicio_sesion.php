<?php
	include('../controladores/controlador.php');
	$controlador = new Controlador();
	
	if(isset($_POST["nombre"]) && !empty($_POST["nombre"]) && isset($_POST["pass"]) && !empty($_POST["pass"])){
		$nombre = $_POST["nombre"];
		$pass = $_POST["pass"];
		$controlador->iniciarSesion($nombre, $pass);
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
	<title>Inicio de Sesión</title>
</head>

<body>
	<header class="header">
		<div class="logo">
			<img src="../../img/logo/logodefinitivo1.png" alt="Logo Limpiemos La Playa" id="logo" />
		</div>
		<nav>
			<ul class="nav-links">
			</ul>
		</nav>
	</header>
	<main>
		<!-- Creado por DOM js -->
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
			<a target="_blank" title="Twitter" href=""><img class="rrss" alt="Icono red social Twitter"
					src="../../img/rrss/twitternar1.png"></a>
			<a target="_blank" title="Facebook" href=""><img class="rrss" alt="Icono red social Facebook"
					src="../../img/rrss/facebooknar1.png"></a>
			<a target="_blank" title="Instagram" href=""><img class="rrss" alt="Icono red social Instagram"
					src="../../img/rrss/instagramnar1.png"></a>
			<a target="_blank" title="LinkedIn" href=""><img class="rrss" alt="Icono red social LinkedIn"
					src="../../img/rrss/linkedinnar1.png"></a>
		</div>
	</footer>
	<script type=module src="../../js/controlador/controladoradmin.js"></script>
</body>

</html>