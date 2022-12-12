<?php
require_once('../modelos/escenario.php');

class ControladorEscenario
{
    private $escenario;
    public function __construct()
    {
        $this->escenario = new Escenario();
    }

    public function getEscenarios()
    {
        return $this->escenario->getAll();
    }

    public function getEscenario($id)
    {
        $fila = $this->escenario->get($id);
        return $fila;
    }
    public function borrarEscenario($id)
    {
        if ($this->escenario->delete($id))
            header("Location: listaescenarios.php");
    }

    public function updateEscenario($arrayPost, $arrayFiles ,$rutaImagen, $id){
        if($this->escenario->update($arrayPost, $arrayFiles, $rutaImagen, $id)){
            header('Location: listarescenarios.php'); 
        }
        else{
            return true;
        }


    }
}
