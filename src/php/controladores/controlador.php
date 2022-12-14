<?php
	include("../modelos/modelo.php");
	/**
	* Contiene el controlador de las vistas del php
	*/
	class Controlador{
		private $objeto;
		/**
		 * Constructor del modelo que contiene la conexion con el servidor de base de datos
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
	}
?>