<?php

class Dificultad
{

    public $id;
    public $nombre;

    public function __construct()
    {
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD) or die("no hay conexion");
        $this->conexion->set_charset('utf8');
    }

    public function getAll()
    {
        $datos = $this->conexion->query("SELECT * FROM dificultad"); //prepare cuando sea losotros con filtros
        return $datos;
    }
}
