<?php
session_start();
if (isset($_POST['cerrarSesion']) || !$_SESSION) {
    session_destroy();
    header('Location: inicio_sesion.php');
}

require_once('../controladores/controladorescenario.php');
require_once('../controladores/controladordificultad.php');

$vacio = false;

$controlador = new ControladorEscenario();
$controladorDificultad = new ControladorDificultad();
$dificultades = $controladorDificultad->getDificultades();


if (isset($_POST) && !empty($_POST)) {
    $vacio = $controlador->addEScenario($_POST, $_FILES);
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
    <title>Alta Escenario</title>
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
                <li><a id="resalto" href="listaescenarios.php">Escenarios</a></li>
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
        <div id="divNuevoEnemigo">
            <h2>Añadir nuevo escenario</h2><br>
            <form enctype="multipart/form-data" action="" method="POST" onSubmit="return confirm('¿Está seguro de querer agregar este escenario?.')">
                <?php
                echo     '<label>Escenario <input type="text" name="nombre"></label> <br><br><br>
								<label>Dificultad: 
                                    <select name="select">' ?>

                <?php
                foreach ($dificultades as $dif) {
                    echo '<option value=' . $dif['id'] . '>' . $dif['nombre'] . '</option>';
                } ?>
                <?php echo
                '</select>
                                </label><br><br><br>
                                <label>Imagen del escenario: <br><br><input type="file" accept="image/png, image/jpg" name="nombreImagen"></label> <br><br><br>
                                <label>Waypoints: <textarea  cols="30" rows="3" name="waypoints" placeholder="Introduce las posiciones disponibles de las torres"></textarea></label><br><br><br>
                                <label>Coordenadas: <textarea cols="30" rows="3" name="coords" placeholder="Introduce la ruta del enemigo"></textarea></label><br><br><br>
								';
                ?>
                <input type="submit" value="AÑADIR">
            </form>
            <a href="listaescenarios.php"><button>CANCELAR</button></a>
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