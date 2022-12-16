<?php
	include("../modelos/modeloenemigos.php");
	/**
	* Contiene el controlador de las vistas del php
	*/
	class Controlador{
		private $modeloEnemigos;
		/**
		 * Constructor del modelo que contiene la conexion con el servidor de base de datos
		 * @return void
		 */
		public function __construct(){
			$this->modeloEnemigos = new ModeloEnemigos();
		}
		/**
		 * Le pide al modelo los datos de los enemigos y los devuelve a la vista.
		 */
		public function datosEnemigos(){
			return $this->modeloEnemigos->selectDatosEnemigos(null);//null porque este método del modelo también se utiliza en el modificar.
		}
		/**
		 * Le pide al modelo los datos del enemigo que se quiera modificar y los devuelve a la vista.
		 * @param {Integer} $id Id del enemigo a modificar.
		 */
		public function datosEnemigoModificar($id){
			return $this->modeloEnemigos->selectDatosEnemigos($id);
		}
		/**
		 * Le manda los nuevos datos de enemigo al modelo.
		 * @param {Array} $datos Array con los nuevos datos.
		 * @param {Array} $file Array con los datos de un fichero (name, tmp_name, error...).
		 * @param {String} $rutaImagenEliminar Nombre de la ruta de la imagen antigua asociada al enemigo.
		 * @param {Integer} $id Id del enemigo que se va a modificar.
		 */
		public function modificarEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id){
			if($this->modeloEnemigos->updateDatosEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id)){
				header('Location: listarenemigos.php'); //Para que la página se recargue y salgan los datos actualizados en la tabla.
			}
			else{
				return true;
			}
		}
		/**
		 * Le manda el id del enemigo a borrar al modelo.
		 * @param {Integer} $id Id del enemigo a borrar.
		 */
		public function borrarEnemigo($id, $nombreImagen){
			if($this->modeloEnemigos->borrarDatosEnemigo($id, $nombreImagen)){
				header('Location:listarenemigos.php');
			}
		}
		/**
		 * Le manda los datos del enemigo a crear al modelo.
		 * @param {Array} $datos Array con los nuevos datos.
		 * @param {Array} $file Array con los datos de un fichero (name, tmp_name, error...).
		 */
		public function altaEnemigo($datosEnemigo, $file){
			if($this->modeloEnemigos->altaDatosEnemigo($datosEnemigo, $file)){
				header('Location: listarenemigos.php'); //Para que la página se recargue y salgan los datos actualizados en la tabla.
			}
			else{
				return true;
			}
		}
	}
?>