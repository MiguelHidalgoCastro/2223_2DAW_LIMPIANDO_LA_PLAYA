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
        <meta name="author" content="Grupo Limpiemos La Playa 2DAW 22/23" />
        <link rel="shortcut icon" href="../../img/logo/logoicon.png">
        <link rel="stylesheet" href="../../css/style.css">
        <title>Modificar torre</title>
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
                    <li><a href="#">Configuración</a></li>
                    <li><a href="#">Escenarios</a></li>
                    <li><a href="#">Defensas</a></li>
                    <li><a href="#">Enemigos</a></li>
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
                <h2>Modificar torre</h2><br>
                <form action="modificar_torre" method="POST"><!--El actionm todavía no se usa-->
                    <label>Nombre de la torre: <input type="text" name="nameTorre" value="Pescador solitario"></label> <br><br><br>
                    <label>Radio de actuación: <input type="number" name="radioTorre" value="150"></label><br><br><br>
                    <label>Velocidad de recorrido: <input type="number" name="velTorre" value="20"></label><br><br><br>
                    <label>Nombre de la imagen: <br><br><input type="file" name="nameImgTorre" value="<img src=>"></label> <br><br><br>
                    <input type="submit" value="MODIFICAR"><br><br>

                    <!--Para saber como se debe generar los inputs correctamente
                    <label>Ejemplo<input type="text"></label>
                    <label for="paratexto">Ejemplo</label><input type="text" id="paratexto">
                    -->
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
        <!--<script src="../../js/controlador/controladorAdmin.js"></script>-->
    </body>
</html>