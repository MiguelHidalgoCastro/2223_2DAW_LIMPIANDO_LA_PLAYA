<?php
session_start();
if (isset($_POST['cerrarSesion']) || !$_SESSION) {
	session_destroy();
	header('Location: inicio_sesion.html');
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="FREE CHAPAPOTE" />
        <link rel="shortcut icon" href="../../img/logo/logoicon.png">
        <link rel="stylesheet" href="../../css/style.css">
        <title>Configuración</title>
    </head>

    <body>
        <header class="header">
            <div class="logo">
                <img src="../../img/logo/logodefinitivo1.png" alt="Logo Limpiemos La Playa" id="logo" />
            </div>
            <nav id="flex-container">
                 <input type="checkbox" id="check" />
				<label for="check" id="btnMenu">
					<img src="../../img/iconos/menu.png" alt="Icono de menú" />
				</label>
                <ul class="nav-links">
                    <li id="item1"><a href="inicio_admin.php">Inicio</a></li>
                    <li id="item2"><a href="#">Configuración</a></li>
                    <li id="item3"><a href="#">Escenarios</a></li>
                    <li id="item4"><a href="#">Defensas</a></li>
                    <li id="item5"><a href="#">Enemigos</a></li>
                    <li id="item6">
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
                <form action="configuracion.php" method="POST" id="formConfiguracion">
                    <label>Ruta torre <input type="text" name="rutaTorre"></label> 
                    <input type="text" name="rutaEnemigo" class="rutar"> <label for="rutaEnemigo" class="rutar">Ruta enemigo</label><br>
                    <label class="centro">Ruta escenario <input type="text" name="rutaEscenario" class="centro"></label><br><br><hr><br>
                    <h4>Medidas de la ventana</h4><br>
                    <!--<label for="medidasVentana" id="medidaVentana">Medidas de la ventana de juego</label><br>-->
                    <label for="medidaAlto" class="alto">Alto de la pantalla</label> <label for="medidaAncho" class="ancho">Ancho de la pantalla</label><br><br>
                    <input type="number" name="medidaAlto" value="540" class=alto> <input type="number" name="medidaAncho" value="980" class="ancho"><br><br><hr><br>
                    <h4>Filas de la tabla ranking</h4><br>
                    <label class="centro">Jugadores que aparecerán en el ranking <input type="number" value="10" name="filasRanking"></label><br><br>
                    <input type="submit" value="Guardar cambios" >             
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
				<a target="_blank" title="Twitter" href=""><img class="rrss" alt="Icono red social Twitter" src= "../../img/rrss/twitternar1.png"></a>
				<a target="_blank" title="Facebook" href=""><img class="rrss" alt="Icono red social Facebook" src= "../../img/rrss/facebooknar1.png"></a>
				<a target="_blank" title="Instagram" href=""><img class="rrss" alt="Icono red social Instagram" src= "../../img/rrss/instagramnar1.png"></a>
				<a target="_blank" title="LinkedIn" href=""><img class="rrss" alt="Icono red social LinkedIn" src= "../../img/rrss/linkedinnar1.png"></a>
			</div>
        </footer>
    </body>
</html>