<?php
require_once('../modelos/dificultad.php');

/**
 * Clase ControladorDificultad
 * 
 */
class ControladorDificultad
{
    /**
     * Atributos
     */
    public $dificultad;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dificultad = new Dificultad();
    }
    /**
     * Le pido al modelo que me devuelva las dificultades
     * @return {array} devuelve un array con las dificultades
     */
    public function getDificultades()
    {
        return $this->dificultad->getAll();
    }
}
