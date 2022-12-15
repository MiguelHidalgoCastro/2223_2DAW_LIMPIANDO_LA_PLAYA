<?php
    include('../config/conexion.php');

    /**
     * Summary of Modelo  Clase que contiene el modelo de la aplicacion
     */
    class Modelo{
        private $mysqli;

        /**
         * Constructor del modelo que contiene la conexion con el servidor de base de datos
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
                $consulta = $this->mysqli-> query('SELECT * FROM lp_torres');
            }
            else
            {
                $consulta = $this->mysqli->query('SELECT * FROM lp_torres WHERE id="'.$id.'"');	
            }

            while($filas = $consulta-> fetch_assoc())
            {
                $datos[] = $filas;
            }

            return $datos; //Devuelbe los datos y se mandarán al controlador
        }

        /* Borrar torre */

        /**
         * Summary of borrarDatosTorres Elimina la torre asociada al id
         * @param {int} $id Id de la torre que se quiere borrar
         * @return bool
         */
        public function borrarDatosTorres($id)
        {
            $consulta = $this-> mysqli-> prepare('DELETE FROM lp_torres WHERE id=?');
            $consulta-> bind_param('i', $id);
            $consulta->execute();
            $consulta->close();
            return true;
        }

        /*Alta de torres*/
        /**
         * Summary of altaDatosTorres Realiza el alta de la torre
         * @param {Array}] $datosTorre Datos de la torre que se va añadir
         * @param {file} $file Archivo (imagen) de la torre que se va a añadir
         * @return bool
         */
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
                $consulta = $this->mysqli->prepare("INSERT INTO lp_torres (nombre, radioActuacion, velocidadRecorrido, nombreImagen) VALUES (?, ?, ?, ?)");
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
        /**
         * Summary of selectDatosTorres Muestra los valores de las torres en la tabla
         * de la vista listartorres.php
         * @param {Int} $id Identificativo de cada torre
         * @return {Array} $datos Array que guarda los datos de las torres
         */
        public function selectDatosTorres($id)
        {
            $datos = null;

            if(!isset($id))
            {
                $consulta = $this-> mysqli-> query("SELECT * FROM lp_torres");
            }
            else
            {
                $consulta = $this-> mysqli-> query('SELECT * FROM lp_torres WHERE id="'.$id.'"');
            }

            while($filas=$consulta->fetch_assoc())
            {
                $datos[] = $filas;
            }

            return $datos;
        }

        /**
         * Summary of actualizarDatosTorre Actualiza los datos de la torre seleccionado en la base de datos 
         * @param {Array} $datosTorre
         * @param {mixed} $file
         * @param {String} $rutaImagenEliminar
         * @param {Int} $id
         * @return bool
         */
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

                $consulta = $this-> mysqli-> prepare("UPDATE lp_torres SET nombre=?, radioActuacion=?, velocidadRecorrido=?, nombreImagen=? WHERE id=?");
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