<?php
include('../config/conexion.php');
/**
 * Clase que contiene el modelo de la aplicacion
 * @author Grupo Limpiemos la Playa
 */
class ModeloEnemigos
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
	 * Muestra los valores de todos los enemigos en la tabla de la vista de enemigos.
	 */
	public function selectDatosEnemigos($id)
	{
		$datos = null;

		if (!isset($id))
			$consulta = $this->mysqli->query("SELECT * FROM lp_enemigos");
		else
			$consulta = $this->mysqli->query('SELECT * FROM lp_enemigos WHERE id="' . $id . '"');

		while ($filas = $consulta->fetch_assoc()) {
			$datos[] = $filas;
		}

		return $datos;
	}
	/**
	 * Actualiza los datos del enemigo seleccionado en la base de datos.
	 * @param {Array} $datos Lista de datos que han sido introducidos en el formulario de modificar enemigo.
	 */
	public function updateDatosEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id)
	{
		if (
			isset($datosEnemigo["nombre"]) && !empty($datosEnemigo["nombre"])
			&& isset($datosEnemigo["velocidadMov"]) && !empty($datosEnemigo["velocidadMov"])
			&& isset($datosEnemigo["puntos"]) && !empty($datosEnemigo["puntos"])
			&& isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"])
		) {

			unlink(realpath($rutaImagenEliminar));

			$nombreImagen = $file["nombreImagen"]["name"];
			$rutaImagen = "../../img/subidas/enemigos/" . $nombreImagen;
			$archivo = $file["nombreImagen"]["tmp_name"];
			$subir = move_uploaded_file($archivo, $rutaImagen);


			$consulta =  $this->mysqli->prepare("UPDATE lp_enemigos 
													SET nombre= ?,
													velocidadMov= ?,
													puntos= ?,
													nombreImagen= ?
													WHERE id = ?");
			$consulta->bind_param("ssssi", $datosEnemigo["nombre"], $datosEnemigo["velocidadMov"], $datosEnemigo["puntos"], $rutaImagen, $id);
			$consulta->execute();
			$consulta->close();
			return true;
		} else {
			return false; /* Para controlar los mensajes de alertas */
		}
	}
	/**
	 * Elimina el enemigo asociado al id.
	 */
	public function borrarDatosEnemigo($id, $nombreImagen)
	{
		unlink(realpath($nombreImagen));
		
		$consulta = $this->mysqli->prepare("DELETE FROM lp_enemigos WHERE id = ?");
		$consulta->bind_param("i", $id);
		$consulta->execute();
		$consulta->close();
		return true;
	}
	/**
	 * Alta del enemigo.
	 * @param {Array} $datosEnemigo Lista de datos que han sido introducidos en el formulario de añadir enemigo.
	 */
	public function altaDatosEnemigo($datosEnemigo, $file)
	{
		if (
			isset($datosEnemigo["nombre"]) && !empty($datosEnemigo["nombre"])
			&& isset($datosEnemigo["velocidadMov"]) && !empty($datosEnemigo["velocidadMov"])
			&& isset($datosEnemigo["puntos"]) && !empty($datosEnemigo["puntos"])
			&& isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"])
		) {
			$nombreImagen = $_FILES["nombreImagen"]["name"];
			$rutaImagen = "../../img/subidas/enemigos/" . $nombreImagen;
			$archivo = $_FILES["nombreImagen"]["tmp_name"];
			$subir = move_uploaded_file($archivo, $rutaImagen);

			$consulta =  $this->mysqli->prepare("INSERT INTO lp_enemigos (nombre, velocidadMov, puntos, nombreImagen)
														VALUES(?,?,?,?)");
			$consulta->bind_param("siis", $datosEnemigo["nombre"], $datosEnemigo["velocidadMov"], $datosEnemigo["puntos"], $rutaImagen);
			$consulta->execute();
			$consulta->close();

			return true;
		} else {
			return false;
		}
	}
}