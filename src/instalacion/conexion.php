<?php
/*Conexión Sergio*/
/*define("SERVIDOR",'2daw.esvirgua.com');
define("USUARIO",'user2daw_15');
define("PASSWORD","Q{Hq-DjOPX02");
define("BBDD",'user2daw_BD1-15');*/

/*Conexión Antonio*/
/*DEFINE('SERVIDOR', '2daw.esvirgua.com');
DEFINE('USUARIO', 'user2daw_09');
DEFINE('PASSWORD', 'v;$^Z]4xXphS');
DEFINE('BD', 'user2daw_BD1-09');*/


define("SERVIDOR",'localhost');
define("USUARIO",'root');
define("PASSWORD","");
define("BBDD",'login');
$mysqli=new mysqli(SERVIDOR,USUARIO,PASSWORD,BBDD);

?>
