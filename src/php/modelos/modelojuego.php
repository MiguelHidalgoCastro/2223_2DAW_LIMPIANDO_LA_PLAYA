<?php
include('php/config/conexion.php');
/**
 * Clase que contiene el modelo de la aplicacion
 * @author Grupo Limpiemos la Playa
 */
class ModeloRanking
{

	private $mysqli;
	/**
	 * Constructor del modelo que contiene la conexion con el servidor de base de datos
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->mysqli = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD) or die("no hay conexion");
		$this->mysqli->set_charset('utf8');
	}
	/**
	 * Alta del enemigo.
	 * @param {Array} $datosEnemigo Lista de datos que han sido introducidos en el formulario de añadir enemigo.
	 */
	public function altaJugadorRanking($datosJugador)
	{
        var_dump($datosJugador);
		if (isset($datosJugador) && !empty($datosJugador)) {

			$consulta =  $this->mysqli->prepare("INSERT INTO lp_ranking (alias, puntos)
														VALUES(?,?)");
			$consulta->bind_param("si", $datosJugador["nickname"], $datosJugador["puntos"]);
			$consulta->execute();
			$consulta->close();

			return true;
		} else {
			return false;
		}
	}
}