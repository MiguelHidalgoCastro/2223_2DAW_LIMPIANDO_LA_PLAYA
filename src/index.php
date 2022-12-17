<?php
	include('php/controladores/controladorjuego.php');
	
	$controlador = new Controlador();
	if(isset($_POST) && !empty($_POST)){
		$controlador->altaJugador($_POST);
	}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Miguel Hidalgo Catro 2DAW 22/23" />
	<link rel="shortcut icon" href="img/logo/logoicon.png">
	<title>JUEGO</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<audio id="inicio">
        <source src="sonido/iniciojuego.mp3" type="audio/mp3">  
    </audio>
	<audio id="derrota">
        <source src="sonido/derrota.mp3" type="audio/mp3">  
    </audio>
	<header class="header">
		<div class="logo">
			<img src="img/logo/logodefinitivo1.png" alt="Logo Limpiemos La Playa" id="logo" />
		</div>
		<nav>
			<input type="checkbox" id="check">
			<label for="check" id="btnMenu">
				<img src="img/iconos/menu.png" alt="Icono de menú" />
			</label>
			<ul class="nav-links">
				<li><a href="index.php">Juego</a></li>
				<li><a href="php/vistas/ranking.php">Ranking</a></li>
			</ul>
		</nav>
	</header>
	
	<main>
		<svg id="mute" height="48" width="48"><path d="m40.65 45.2-6.6-6.6q-1.4 1-3.025
			1.725-1.625.725-3.375 1.125v-3.1q1.15-.35 2.225-.775 1.075-.425
			2.025-1.125l-8.25-8.3V40l-10-10h-8V18h7.8l-11-11L4.6 4.85 42.8
			43Zm-1.8-11.6-2.15-2.15q1-1.7 1.475-3.6.475-1.9.475-3.9 0-5.15-3-9.225-3-4.075-8-5.175v-3.1q6.2
			1.4 10.1 6.275 3.9 4.875 3.9 11.225 0 2.55-.7 5t-2.1 4.65Zm-6.7-6.7-4.5-4.5v-6.5Q30 17 31.325 19.2q1.325 2.2
			1.325 4.8 0 .75-.125 1.475-.125.725-.375 1.425Zm-8.5-8.5-5.2-5.2 5.2-5.2Zm-3
			14.3v-7.5l-4.2-4.2h-7.8v6h6.3Zm-2.1-9.6Z"/>
		</svg>
		<svg id="play" height="48" width="48"><path d="M28 41.45v-3.1q4.85-1.4
			 7.925-5.375T39 23.95q0-5.05-3.05-9.05-3.05-4-7.95-5.35v-3.1q6.2 1.4
			  10.1 6.275Q42 17.6 42 23.95t-3.9 11.225Q34.2 40.05 28 41.45ZM6 30V18h8L24
			   8v32L14 30Zm21 2.4V15.55q2.75.85 4.375 3.2T33 24q0 2.85-1.65 5.2T27
				32.4Zm-6-16.8L15.35 21H9v6h6.35L21 32.45ZM16.3 24Z"/>
		</svg>
		<div id="divContenedorPosition">
			<img id="instrucciones" src="img/iconos/instrucciones.png" onclick='aparece()'>
			<div id="divInstrucciones">
				<h2 id="ins1">Instrucciones</h2><br>
				El juego es muy sencillo y cualquiera puede jugar. Consiste en conseguir que la basura no llegue
				hasta el final del río. Cada vez que una basura llegue al final se le restará 1 vida.<br><br>
				<h2>¿Cómo juego?</h2><br>
				Es muy sencillo, hay que colocar los diferentes tipos de pescadores sobre la zona gris del mapa,
				para hacerlo arrastramos el pescador que queremos a la zona del mapa que elijamos. Una vez colocado
				el pesacador empezará a recoger la basura que aparezca. Colocar las torres tiene un coste de monedas 
				que se te restaran al poner una torre. También es posible mejorar los pescadores para que estos tengan
				un mayor rango de recogida y a mayor velocidad.<br><br>
				<button>Salir</button><img src="img/iconos/siguiente.png" onclick='siguiente()'><br>
				<span>Página 1/2</span>
			</div>
			<div id="instrucciones2">
				<h2>¿Cómo mejoro a los pescadores?</h2>
				Es tan fácil como clikar sobre el pescador que se quiere mejorar. Para este proceso
				hay que tener en cuenta las monedas que tienes, que aparecen arriba del mapa. Comienzas con
				200 monedas y puedes colocar los pescadores que quieras (teniendo monedas suficientes). Cada 
				pescador tiene un coste distinto de monedas dependiendo de su calidad. Para conseguir monedas 
				solo vasta con recoger la basura del río.<br><br>
				<h2>Otros datos</h2>
				Si pasamos el ratón por encima de un pescador que este colocado en el mapa podremos saber:
				<ul>
					<li>Nivel del pescador</li>
					<li>Alcance del pescador</li>
					<li>Basura que ha recogido ese pescador</li>
				</ul><br>  
				<button onclick='salirse()'>Salir</button><img src="img/iconos/anterior.png" onclick='volver()'><br>
				<span>Página 2/2</span>
			</div>
			<div >
				<p id="menu"><img src="boton.png"></p>
			</div>
			<div id="juego">
				<div id="divRankingJuego">
					<h3 id="h3PuntuacionLograda"></h3>
					<form id="formRanking" action="" method="POST">
						<label>Nickname: <input id="nickname" type="text" name="nickname"></label>
						<input type="submit" value="GUARDAR PTS">
						<input id="puntosOculto" type="text" name="puntos">
					</form>
					<a href="index.html"><button>CANCELAR</button></a>
				</div>
				<h1 id="mensajeAviso">SÓLO VERSIÓN DESKTOP</h1>
				<canvas></canvas>
			</div>
			<div id="divCaracteristicas">
				<p id="pLvl"></p>
				<p id="pAlcance"></p>
				<p id="pRecogidos"></p>
			</div>
		</div>
	</main>
	<audio id="bichoMuerto">
		<source src="sonido/arcade.mp3">
	</audio>
	<script type="module" src="js/controlador/app.js"></script>
	<script src="js/coordenadas/coordenadas.js"></script>
	<script src="js/coordenadas/waypoints.js"></script>
	<script>

		let divInstrucciones = document.getElementsByTagName('div')[2]
		let btnSalir = document.getElementsByTagName('button')[0]
		let div2 = document.getElementsByTagName('div')[3]
		//let btnSalte = document.getElementsByTagName(button)[1]

		function aparece(){
			divInstrucciones.style.display = 'block';

			//Añadimos evento a el boton
			btnSalir.addEventListener('click', salir)
		} 

		function salir()
		{
			//console.log(divInstrucciones)
			divInstrucciones.style.display = 'none'
		}

		function siguiente()
		{
			divInstrucciones.style.display = 'none'
			div2.style.display = 'block'

		}

		function volver()
		{
			divInstrucciones.style.display = 'block'
			div2.style.display = 'none'
		}

		function salirse()
		{
			div2.style.display = 'none'
		}
	</script>
</body>
</html>