<?php
include('../config/conexion.php');
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
           
			$consulta =  $this->mysqli->prepare ("SELECT * FROM administrador where nombre = ? and perfil = ?");
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
	 *
	 * @return void
	 */
	public function borrarFichero($fichero){
		rmdir($fichero);
	}
	/**
	 * Realiza una consulta a la base de datos y le manda al controlador los datos de configuración.
	 */
	public function selectDatosConfig(){
		$consulta =  $this->mysqli->prepare ("SELECT * FROM configuracion");
		$consulta->execute();
		
		$resultado = $consulta->get_result();
		
		
		$datos = $resultado ->fetch_array();
		//$consulta->fetch();//Buscar qué hace esto
		$consulta->close();
		
		return $datos;
	}
	/**
	 * Actualiza los datos de configuración en la base de datos.
	 * @param {Array} $datos Lista de datos que han sido introducidos en el formulario de configuración.
	 */
	public function updateDatosConfig($datos){
		if(isset($datos["rutaDefensa"]) && !empty($datos["rutaDefensa"]) 
		&& isset($datos["rutaEnemigo"]) && !empty($datos["rutaEnemigo"])
		&& isset($datos["rutaEscenario"]) && !empty($datos["rutaEscenario"])
		&& isset($datos["medVentana"]) && !empty($datos["medVentana"])
		&& isset($datos["numFilas"]) && !empty($datos["numFilas"])){
			$consulta =  $this->mysqli->prepare ("UPDATE configuracion 
													SET rutaTorre= ?,
													rutaEnemigo= ?,
													rutaEscenario= ?,
													medidaVentanaJuego= ?,
													filasRanking= ?");
			$consulta->bind_param("ssssi", $datos["rutaDefensa"], $datos["rutaEnemigo"], $datos["rutaEscenario"], $datos["medVentana"], $datos["numFilas"]);
			$consulta->execute();
			$consulta->close();
			return true;
		}
		else{
			return false;
		}
		
		
	}
	/**
	 * Muestra los valores de todos los enemigos en la tabla de la vista de enemigos.
	 */
	public function selectDatosEnemigos($id){
		$datos=null;
		
		if(!isset($id))
			$consulta = $this->mysqli->query("SELECT * FROM enemigos");
		else	
			$consulta = $this->mysqli->query('SELECT * FROM enemigos WHERE id="'.$id.'"');
		
		while($filas=$consulta->fetch_assoc()){
			$datos[]=$filas;
		}
		
		return $datos;
		
	}
	/**
	 * Actualiza los datos del enemigo seleccionado en la base de datos.
	 * @param {Array} $datos Lista de datos que han sido introducidos en el formulario de modificar enemigo.
	 */
	public function updateDatosEnemigo($datosEnemigo, $file, $rutaImagenEliminar, $id){
		if(isset($datosEnemigo["nombre"]) && !empty($datosEnemigo["nombre"])
		&& isset($datosEnemigo["velocidadMov"]) && !empty($datosEnemigo["velocidadMov"])
		&& isset($datosEnemigo["puntos"]) && !empty($datosEnemigo["puntos"])
		&& isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"])){
			
			unlink(realpath($rutaImagenEliminar));

			$nombreImagen = $file["nombreImagen"]["name"];
			$rutaImagen = "../../img/subidas/enemigos/".$nombreImagen;
			$archivo = $file["nombreImagen"]["tmp_name"];
			$subir = move_uploaded_file($archivo,$rutaImagen);
			
			
			$consulta =  $this->mysqli->prepare ("UPDATE enemigos 
													SET nombre= ?,
													velocidadMov= ?,
													puntos= ?,
													nombreImagen= ?
													WHERE id = ?");
			$consulta->bind_param("ssssi", $datosEnemigo["nombre"], $datosEnemigo["velocidadMov"], $datosEnemigo["puntos"], $rutaImagen, $id);
			$consulta->execute();
			$consulta->close();
			return true;
		}
		else{
			return false; /* Para controlar los mensajes de alertas */
		}
	}
	/**
	 * Elimina el enemigo asociado al id.
	 */
	public function borrarDatosEnemigo($id){
		$consulta = $this->mysqli->prepare("DELETE FROM enemigos WHERE id = ?");
		$consulta->bind_param("i",$id);
		$consulta->execute();
		$consulta->close();
		return true;
	}
	/**
	 * Alta del enemigo.
	 * @param {Array} $datosEnemigo Lista de datos que han sido introducidos en el formulario de añadir enemigo.
	 */
	public function altaDatosEnemigo($datosEnemigo,$file){
		if(isset($datosEnemigo["nombre"]) && !empty($datosEnemigo["nombre"]) 
		&& isset($datosEnemigo["velocidadMov"]) && !empty($datosEnemigo["velocidadMov"])
		&& isset($datosEnemigo["puntos"]) && !empty($datosEnemigo["puntos"])
		&& isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"])){
			$nombreImagen = $_FILES["nombreImagen"]["name"];
			$rutaImagen = "../../img/subidas/enemigos/".$nombreImagen;
			$archivo = $_FILES["nombreImagen"]["tmp_name"];
			$subir = move_uploaded_file($archivo,$rutaImagen);
			
			$consulta =  $this->mysqli->prepare ("INSERT INTO enemigos (nombre, velocidadMov, puntos, nombreImagen)
														VALUES(?,?,?,?)");
			$consulta->bind_param("siis",$datosEnemigo["nombre"], $datosEnemigo["velocidadMov"], $datosEnemigo["puntos"], $rutaImagen);
			$consulta->execute();
			$consulta->close();
			
			return true;
		}
		else{
			return false;
		}
	}
}