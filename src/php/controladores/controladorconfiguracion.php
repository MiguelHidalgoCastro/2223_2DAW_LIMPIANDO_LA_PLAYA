<?php
	include("../modelos/modeloconfiguracion.php");
	/**
	* Contiene el controlador de las vistas del php
	*/
	class Controlador{
		private $modeloConfiguracion;
		/**
		 * Constructor del modelo que contiene la conexion con el servidor de base de datos
		 * @return void
		 */
		public function __construct(){
			$this->modeloConfiguracion = new ModeloConfiguracion();
		}
		/**
		 * Valida la el usuario y la contraseña del inicio de sesión y devuelve la vista de inicio u otra vez la vista de 
		 * inicio de sesión según sean correctos o no los campos.
		 * @param {String} $nombre Nombre de usuario
		 * @param {String} $pass Contraseña del usuario encriptada
		 */
		public function iniciarSesion($nombre, $pass){
			if(isset($nombre) && !empty($nombre) && isset($pass) && !empty($pass)){
				if($this->modeloConfiguracion->validarUsuario($nombre , $pass)){
					header("Location:../vistas/inicio_admin.php");
					var_dump($nombre);
				}
				else
				{
					header("../vistas/inicio_sesion.html");
				}
			}
			else
			{
				header("../vistas/inicio_sesion.html");
			}
		}
		/**
		 * Le pide al modelo los datos de configuración y los devuelve a la vista.
		 */
		public function datosConfiguracion(){
			return $this->modeloConfiguracion->selectDatosConfig();
		}
		/**
		 * Le manda los nuevos datos de configuración al modelo.
		 * @param {Array} $datos Array con los nuevos datos
		 */
		public function modificarConfiguracion($datosConfig){
			
			if($this->modeloConfiguracion->updateDatosConfig($datosConfig)){
				header('Location: configuracion.php'); //Para que la página se recargue y salgan los datos actualizados en el input.
			}
			else{
				return true;
			}
		}
	}
?>