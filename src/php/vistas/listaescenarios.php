<?php
/*Recuerda la sesión*/
session_start();
if (isset($_POST['cerrarSesion']) || !$_SESSION) {
    session_destroy();
    header('Location:inicio_sesion.php');
}


require_once('../controladores/controladorescenario.php');
require_once('../controladores/controladordificultad.php');

$controlador = new ControladorEscenario();
$datos = $controlador->getEscenarios();

$controladorDificultad = new ControladorDificultad();
$dificultades = $controladorDificultad->getDificultades();
$difs = [];
foreach ($dificultades as $dif) {
    array_push($difs, $dif['nombre']);
}

if (isset($_GET['action'])) {
    $controlador->borrarEscenario($_GET["id"]);
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
    <title>Listado de Escenarios</title>
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
                <li><a href="#">Defensas</a></li>
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
        <div id="divEnemigos">
            <h1>Listado de Escenarios</h1><br>
            <table id="tableEnemigos">
                <tr>
                    <th>Nombre</th>
                    <th>Dificultad</th>
                    <th>WayPoints</th>
                    <th>Ruta</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                <?php
                if ($datos) {
                    foreach ($datos as $dato) { //Una vez que recorre la primera fila y la mete en un array, el puntero apunta al siguiente.
                        echo "<tr>
									<td>" . $dato["nombre"] . "</td>
									<td>" . $difs[$dato["idDificultad"] - 1] . "</td>
									<td>" . $dato["waypoints"] . "</td>
                                    <td>" . $dato["coordenadas"] . "</td>
									<td><img class=imgTabla src=" . $dato["nombreImagen"] . "></td>
									<td>
										<a href=listaescenarios.php?id=" . $dato["id"] . "&action=borrar><img src=../../img/iconos/delete.png title='borrar'></a>
										<a href=modificarescenario.php?id=" . $dato["id"] . "><img src=../../img/iconos/edit.png title='modificar'></a>
									</td>
							    </tr>";
                    }
                } else {
                    echo '<tr>
								<td colspan=5>No hay ningún escenario registrado<td>
							<tr>';
                }
                ?>
            </table><br>
            <a href="addescenario.php"><input type="submit" value="AÑADIR ESCENARIO"></a><br>
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