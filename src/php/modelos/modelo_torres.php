<?php
    include('../config/conexion.php');

    class Modelo{
        private $mysqli;

        /**
         * Constructor del modelo que contiene la conexion con el servidor de base de datos
         * 
         * @return void
         */
        public function __construct(){
            $this->mysqli = new mysqli(SERVIDOR,USUARIO,PASSWORD,BBDD) or die ("no hay conexion");
        } 

        /*-----Crud de torres------*/

        /**
         * Summary of listaDatosTorres Mostrar los valores de las torres segun su id
         * @param {Int} $id Identificativo de la torre
         * @return {array} $datos Devulbe los datos de las torres 
         */
        public function listaDatosTorres($id){

            $datos = null;

            if(!isset($id))
            {
                $consulta = $this->mysqli-> query('SELECT * FROM torres');
            }
            else
            {
                $consulta = $this->mysqli->query('SELECT * FROM torres WHERE id="'.$id.'"');	
            }

            while($filas = $consulta-> fetch_assoc())
            {
                $datos[] = $filas;
            }

            return $datos; //Devuelbe los datos y se mandarán al controlador
        }

        /* Borrar torre */

        public function borrarDatosTorres($id)
        {
            $consulta = $this-> mysqli-> prepare('DELETE FROM torres WHERE id=?');
            $consulta-> bind_param('i', $id);
            $consulta->execute();
            $consulta->close();
            return true;
        }

        /*Alta de torres*/
        public function altaDatosTorres($datosTorre, $file)
        {
            if(isset($datosTorre["nombre"]) && !empty($datosTorre["nombre"])
            && isset($datosTorre["radioActuacion"]) && !empty($datosTorre["radioActuacion"])
            && isset($datosTorre["velocidadRecorrido"]) && !empty($datosTorre["velocidadRecorrido"])
            && isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"]))
            {
                //Proceso de subida de archivos
                $nombreImagen = $_FILES["nombreImagen"]["name"];
                $rutaImg = '../../img/subidas/torres/'.$nombreImagen;
                $archivo = $_FILES["nombreImagen"]["tmp_name"];
                $subir = move_uploaded_file($archivo,$rutaImg);

                //Proceso de consulta preparada. Añade valores a la tabla torres
                $consulta = $this->mysqli->prepare("INSERT INTO torres (nombre, radioActuacion, velocidadRecorrido, nombreImagen) VALUES (?, ?, ?, ?)");
                $consulta->bind_param("siis", $datosTorre["nombre"], $datosTorre["radioActuacion"], $datosTorre["velocidadRecorrido"], $rutaImg);
                $consulta-> execute();
                $consulta-> close();

                return true;
            }
            else
            {
                return false;
            }
        }

        /*Modificar <torres */
        public function selectDatosTorres($id)
        {
            $datos = null;

            if(!isset($id))
            {
                $consulta = $this-> mysqli-> query("SELECT * FROM torres");
            }
            else
            {
                $consulta = $this-> mysqli-> query('SELECT * FROM torres WHERE id="'.$id.'"');
            }

            while($filas=$consulta->fetch_assoc())
            {
                $datos[] = $filas;
            }

            return $datos;
        }

        public function actualizarDatosTorre($datosTorre, $file, $rutaImagenEliminar, $id)
        {
            if(isset($datosTorre["nombre"]) && !empty($datosTorre["nombre"])
            && isset($datosTorre["radioActuacion"]) && !empty($datosTorre["radioActuacion"])
            && isset($datosTorre["velocidadRecorrido"]) && !empty($datosTorre["velocidadRecorrido"])
            && isset($file["nombreImagen"]["name"]) && !empty($file["nombreImagen"]["name"]))
            {
                unlink(realpath($rutaImagenEliminar));

                $nombreImagen = $file["nombreImagen"]["name"];
                $rutaImagen = "../../img/subidas/torres/".$nombreImagen;
                $archivo = $file["nombreImagen"]["tmp_name"];
                $subir = move_uploaded_file($archivo,$rutaImagen);

                $consulta = $this-> mysqli-> prepare("UPDATE torres SET nombre=?, radioActuacion=?, velocidadRecorrido=?, nombreImagen=? WHERE id=?");
                $consulta-> bind_param('siisi', $datosTorre["nombre"], $datosTorre["radioActuacion"], $datosTorre["velocidadRecorrido"], $rutaImagen, $id);
                $consulta->execute();
                $consulta->close();
                
                return true;
            }
            else
            {
                return false;
            }
        }
    }
?>