<?php
include('../config/conexion.php');
/**
 * Clase que contiene el modelo de la aplicacion
 * @author Grupo Limpiemos la Playa
 */
class ModeloConfiguracion
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
	 * Realiza una consulta a la base de datos y le manda al controlador los datos de configuración.
	 */
	public function selectDatosConfig()
	{
		$consulta =  $this->mysqli->prepare("SELECT * FROM lp_configuracion");
		$consulta->execute();

		$resultado = $consulta->get_result();


		$datos = $resultado->fetch_array();
		//$consulta->fetch();//Buscar qué hace esto
		$consulta->close();

		return $datos;
	}
	/**
	 * Actualiza los datos de configuración en la base de datos.
	 * @param {Array} $datos Lista de datos que han sido introducidos en el formulario de configuración.
	 */
	public function updateDatosConfig($datos)
	{
		if (
			isset($datos["rutaDefensa"]) && !empty($datos["rutaDefensa"])
			&& isset($datos["rutaEnemigo"]) && !empty($datos["rutaEnemigo"])
			&& isset($datos["rutaEscenario"]) && !empty($datos["rutaEscenario"])
			&& isset($datos["medVentana"]) && !empty($datos["medVentana"])
			&& isset($datos["numFilas"]) && !empty($datos["numFilas"])
		) {
			$consulta =  $this->mysqli->prepare("UPDATE lp_configuracion 
													SET rutaTorre= ?,
													rutaEnemigo= ?,
													rutaEscenario= ?,
													medidaVentanaJuego= ?,
													filasRanking= ?");
			$consulta->bind_param("ssssi", $datos["rutaDefensa"], $datos["rutaEnemigo"], $datos["rutaEscenario"], $datos["medVentana"], $datos["numFilas"]);
			$consulta->execute();
			$consulta->close();
			return true;
		} else {
			return false;
		}
	}
}