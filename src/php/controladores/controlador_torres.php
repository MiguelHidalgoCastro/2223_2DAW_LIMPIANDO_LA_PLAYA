<?php
    include('../modelos/modelo_torres.php');

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


        public function datosTorres()
        {
            return $this->objeto->listaDatosTorres(null); 
        }

        public function borrarTorres($id)
        {
            if($this-> objeto-> borrarDatosTorres($id))
            {
                header('Location: listartorres.php');
            }
        }

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

        public function datosModificarTorres($id)
        {
            return $this-> objeto -> selectDatosTorres($id);
        }

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