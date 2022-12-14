<?php
    include('../modelos/modelo_torres.php');

    /**
     * Summary of Controlador Contiene el controlador de las vistas .php
     */
    class Controlador
    {
        private $objeto;
        /**
         * Constructor del modelo que contiene la conexion con el servidor de base de datos
         * @return void
         */
        public function __construct()
        {
            $this->objeto = new Modelo();
        }

        /**
		 * Le pide al modelo los datos de los enemigos y los devuelve a la vista.
		 */
        public function datosTorres()
        {
            return $this->objeto->listaDatosTorres(null); 
        }

        /**
         * Summary of borrarTorres Manda el id de la torre que se quiere borrar al modelo 
         * @param {Integer} $id Id de la torre que se quiere borrar
         */
        public function borrarTorres($id)
        {
            if($this-> objeto-> borrarDatosTorres($id))
            {
                header('Location: listartorres.php');
            }
        }

        /**
         * Summary of nuevaTorre Le manda los datos de la torre que se quiere crear al modelo
         * @param {Array} $datosTorre Array con los nuevos datos
         * @param {Array} $file Array con los datos de un fichero
         */
        public function nuevaTorre($datosTorre, $file)
        {
            if($this-> objeto-> altaDatosTorres($datosTorre, $file))
            {
                header('Location: listartorres.php');
            }
            else
            {
                return true;
            }
        }

        /**
         * Summary of datosModificarTorres Le pide al modelo los datos del enemigo que se quiera modificar y los devuelve a la vista
         * @param {Integer} $id Id de la torre a modificar
         * @return array|null
         */
        public function datosModificarTorres($id)
        {
            return $this-> objeto -> selectDatosTorres($id);
        }

        /**
         * Summary of modificarTorres La funcion modifica las torres 
         * @param {Array} $datosTorre Array con los nuevos datos
         * @param {Array} $file Array con los datos de un fichero
         * @param {String} $rutaImagenEliminar Nombre de la ruta de la imagen antigua de la torre
         * @param {Integer} $id Id de la torre que se va a modificar
         */
        public function modificarTorres($datosTorre, $file, $rutaImagenEliminar, $id)
        {
            if($this-> objeto-> actualizarDatosTorre($datosTorre, $file, $rutaImagenEliminar, $id))
            {
                header('Location: listartorres.php');
            }
            else
            {
                return true;
            }
        }
    }
?>