<?php
require_once('../modelos/dificultad.php');


class ControladorDificultad
{
    public $dificultad;
    public function __construct()
    {
        $this->dificultad = new Dificultad();
    }

    public function getDificultades()
    {
        return $this->dificultad->getAll();
    }
}
