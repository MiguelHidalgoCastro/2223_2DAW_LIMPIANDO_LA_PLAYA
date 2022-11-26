<?php
require("conexion.php");
/**
 * Clase que contiene el modelo de la aplicacion
 * @author Sergio Rivera Salgado
 */
class Modelo {
	
    private $mysqli;
	/**
	 * Constructor del modelo que contiene la conexion con el servidor de base de datos
	 * 
	 * @return void
	 */
    public function __construct(){
		$this->mysqli = new mysqli(SERVIDOR,USUARIO,PASSWORD,BBDD) or die ("no hay conexion");
    }   
    /**
     *
	 * Funcion que valida al administrador de la aplicación
	 * 
	 * Valida al administrador con el nombre y la contraseña ingresadas en el formulario
	 * Con password_verify compara la contraseña guardada en la BBDD que esta encriptada con la ingresada en el formulario
	 * inicia la sesion
	 * 
     * @param  string $nombre 
     * @param  string $pass
     * @return true Si esta validado
	 * @return false Si no esta validado
     */
    public function validarUsuario($nombre, $pass){
		
        if(!empty($nombre) && !empty($pass)){
			
			$perfil="LP";
           
			$consulta =  $this->mysqli->prepare ("SELECT * FROM Administrador where nombre = ? and perfil = ?");
			$consulta->bind_param("ss",$nombre,$perfil);
			$consulta->execute();
			$resultado = $consulta->get_result();
			if ($resultado->num_rows == 1){
			
			$fila = $resultado ->fetch_array(); 
		
			$hash = $fila['clave'];
        
				if(password_verify($pass,$hash)){
					ini_set('session.cookie_lifetime',0);// cuando un navegador finaliza, la cookie de ID de sesión se elimina inmediatamente
					ini_set('session.cookie_httponly',true);//Este ajuste previene del robo de cookies por inyecciones de JavaScript. 
					ini_set('session.use_strict_mode',true);//Para que no puedan usar un id de sesion si no se ha iniciado sesion.
					ini_set('session.use_only_cookies',1); //Las cookies deben estar activas incondicionalmente en el lado del usuario, o las sesiones no funcionarán. 
					session_start();
					$_SESSION['nombre'] = $nombre;
					return true;
				}
				else
				{
					return false;
				}
			}	 
        }
	}
	/**
	 * Borra el fichero de instalacion cuando este cumple el objetivo de crear un administrador 
	 *
	 * @param  mixed $fichero
	 * @return void
	 */
	public function borrarFichero($fichero){
		rmdir($fichero);
	}
}