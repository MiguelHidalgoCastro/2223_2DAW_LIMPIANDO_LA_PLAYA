<?php
	include("../modelos/modelo.php");
	/**
	* Contiene el controlador de las vistas del php
	*/
	class Controlador{
		private $objeto;
		/**
		 * Constructor del modelo que contiene la conexion con el servidor de base de datos
		 * 
		 * @return void
		 */
		 
		public function __construct(){
			$this->objeto = new Modelo();
		}
		/**
		 * Valida la el usuario y la contraseña del inicio de sesión y devuelve la vista de inicio u otra vez la vista de 
		 * inicio de sesión según sean correctos o no los campos.
		 * @param {String} $nombre Nombre de usuario
		 * @param {String} $pass Contraseña del usuario encriptada
		 */
		public function iniciarSesion($nombre, $pass){
			if(isset($nombre) && !empty($nombre) && isset($pass) && !empty($pass)){
				
				if($this->objeto->validarUsuario($nombre , $pass)){
					header("Location:../vistas/inicio_admin.php");
				}
				else
				{
					echo "<h1>Login incorrecto</h1>";
					include ("../vistas/inicio_sesion.html");
				}
			}
			else
			{
				echo "<h1>Debes introducir el usuario y la contraseña</h1>";
				include ("../vistas/inicio_sesion.html");
			}
		}
		/**
		 * Le pide al modelo los datos de configuración y los devuelve a la vista.
		 */
		public function datosConfiguracion(){
			return $this->objeto->selectDatosConfig();
		}
		/**
		 * Le manda los nuevos datos de configuración al modelo.
		 * @param {Array} $datos Array con los nuevos datos
		 */
		public function modificarConfiguracion($datosConfig){
			
			if($this->objeto->updateDatosConfig($datosConfig)){
				header('Location: configuracion.php'); //Para que la página se recargue y salgan los datos actualizados en el input.
			}
			else{
				return true;
			}
		}
		/**
		 * Le pide al modelo los datos de los enemigos y los devuelve a la vista.
		 */
		public function datosEnemigos(){
			return $this->objeto->selectDatosEnemigos(null);//null porque este método del modelo también se utiliza en el modificar.
		}
		/**
		 * Le pide al modelo los datos del enemigo que se quiera modificar y los devuelve a la vista.
		 * @param {Integer} $id Id del enemigo a modificar.
		 */
		public function datosEnemigoModificar($id){
			return $this->objeto->selectDatosEnemigos($id);
		}
		/**
		 * Le manda los nuevos datos de enemigo al modelo.
		 * @param {Array} $datos Array con los nuevos datos.
		 * @param {Array} $file Array con los datos de un fichero (name, tmp_name, error...).
		 * @param {String} $rutaImagenEliminar Nombre de la ruta de la imagen antigua asociada al enemigo.
		 * @param {Integer} $id Id del enemigo que se va a modificar.
		 */
		public function modificarEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id){
			if($this->objeto->updateDatosEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id)){
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
		public function borrarEnemigo($id){
			if($this->objeto->borrarDatosEnemigo($id)){
				header('Location:listarEnemigos.php');
			}
		}
		/**
		 * Le manda los datos del enemigo a crear al modelo.
		 * @param {Array} $datos Array con los nuevos datos.
		 * @param {Array} $file Array con los datos de un fichero (name, tmp_name, error...).
		 */
		public function altaEnemigo($datosEnemigo, $file){
			if($this->objeto->altaDatosEnemigo($datosEnemigo, $file)){
				header('Location: listarenemigos.php'); //Para que la página se recargue y salgan los datos actualizados en la tabla.
			}
			else{
				return true;
			}
		}
	}
?>