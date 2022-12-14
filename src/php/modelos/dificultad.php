<?php

/**
 * Clase que contiene el Modelo Dificultad
 */
class Dificultad
{
    public $id;
    public $nombre;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD) or die("no hay conexion");
        $this->conexion->set_charset('utf8');
    }
    /**
     * Ejecuta una consulta para traer las dificultades
     * @return {array} Array con todos las dificultades
     */
    public function getAll()
    {
        $datos = $this->conexion->query("SELECT * FROM dificultad"); 
        return $datos;
    }
}
