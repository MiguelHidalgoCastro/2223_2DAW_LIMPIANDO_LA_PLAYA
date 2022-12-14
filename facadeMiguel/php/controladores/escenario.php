<?php

/**
 * Controlador de Escenario
 */

class ControladorEscenario
{
	function __construct($configuracion)
	{
		$this->configuracion = $configuracion;
	}

	/**
	 *	Devuelve una vista HTML con la lista de escenarios
	 */
	function get($usuario, $pathParams, $queryParams)
	{

		//Control de acceso y de roles
		//Llamar al modelo y pedirle los datos
		require_once($this->configuracion['path_modelos'] . 'escenario.php');
		$modelo = new Escenario();
		$datos = $modelo->getAll();
		//Ajustar el formato de los datos a lo que quiere la vista
		if (!isset($pathParams[2])) {
			require_once($this->configuracion['path_vistas'] . 'vistalistaescenarios.php');
			$vista = new VistaListaEscenarios($this->configuracion);
			$vista->mostrar($datos);
		} else if ($pathParams[2] == 'vercrear') {
			require_once($this->configuracion['path_vistas'] . 'vistacrearescenario.php');
			$vista = new VistaCrearEscenario($this->configuracion);
			$vista->mostrar($datos);
		} else if ($pathParams[2] == 'modificar') {
			require_once($this->configuracion['path_vistas'] . 'vistamodescenario.php');
			$vista = new VistaModEscenario($this->configuracion);
			$vista->mostrar($datos);
		}
	}

	function post($usuario, $pathParams, $queryParams, $body)
	{
		if (isset($_POST['accion'])) {
			if ($_POST['accion'] === 'crear') {
				require_once($this->configuracion['path_modelos'] . 'escenario.php');
				$nuevoescenario = new Escenario();
				$nuevoescenario2 = new Escenario();
				$nuevoescenario->nombre = $_POST['inputname'];
				$nuevoescenario->dificultad = $_POST['inputdificultad'];
				$nuevoescenario->waypoints = $_POST['textwaypoints'];
				$nuevoescenario->coords = $_POST['textcoords'];
				$nuevoescenario->rutaImagen = $_POST['inputruta'];
				$nuevoescenario->add();
				if (!empty($_POST['inputname2'])) {
					$nuevoescenario2->nombre = $_POST['inputname2'];
					$nuevoescenario2->dificultad = $_POST['inputdificultad2'];
					$nuevoescenario2->waypoints = $_POST['textwaypoints2'];
					$nuevoescenario2->coords = $_POST['textcoords2'];
					$nuevoescenario2->rutaImagen = $_POST['inputruta2'];
					$nuevoescenario2->add();
				}
				header('Location: ../../escenario'); //Refresh:0, url=../
			}
			if ($_POST['accion'] === 'modificar') {
			}
		}
	}
}
