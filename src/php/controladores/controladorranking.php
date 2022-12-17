<?php
	include("../modelos/modeloranking.php");

	/**
	* Contiene el controlador de las vistas del php
	*/
	class Controlador{
		private $modeloRanking;

		/**
		 * Constructor del modelo que contiene la conexion con el servidor de base de datos
		 * @return void
		 */
		public function __construct(){
			$this->modeloRanking = new ModeloRanking();
		}
        

        /*HACER BIEN*/
        function altaJugador($datosJugador){
            if($this->modeloRanking->altaJugadorRanking($datosJugador)){
                header('Location: index.php');
            }  
        }
		/**
		 * Le pide al modelo los datos de los jugadores y los devuelve a la vista.
		 */
		public function datosRanking(){
			return $this->modeloRanking->selectDatosRanking();
		}
        
	}
?>