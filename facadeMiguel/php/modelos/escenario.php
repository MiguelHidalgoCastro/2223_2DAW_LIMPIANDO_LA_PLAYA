<?php

//class Escenario extends ConfigDB
class Escenario
{
    public $id;
    public $nombre;
    public $dificultad;
    public $waypoints;
    public $coords;
    public $rutaImagen = null;

    public function __construct()
    {
        $this->conexion = new mysqli("2daw.esvirgua.com", "user2daw_06", "6F.Z@GPTwB!s", "user2daw_BD2-06");
        $this->conexion->set_charset('utf8');
    }

    public function getAll()
    {
        $datos = $this->conexion->query("SELECT * FROM escenarios"); //prepare cuando sea losotros con filtros
        return $datos;
    }

    public function get($id)
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("SELECT * FROM escenarios WHERE id=?");
        $prepare->bind_param('i', $id);
        $prepare->execute();
        $result = $prepare->get_result();
        return $result->fetch_assoc();
    }

    public function add() //el nombre lo añado cuando creo el objeto escenario
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("INSERT INTO escenarios(nombre, dificultad, waypoints, coords, rutaImagen) VALUES(?,?,?,?,?)");
        $prepare->bind_param('sssss', $this->nombre, $this->dificultad, $this->waypoints, $this->coords, $this->rutaImagen);
        $prepare->execute();
    }
    public function update() //el nombre lo añado cuando creo el objeto escenario
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("UPDATE escenarios SET nombre=?, dificultad=?, waypoints=?, coords=?, rutaImagen=?,  WHERE id=?");
        $prepare->bind_param('sssssi', $this->nombre, $this->dificultad, $this->waypoints, $this->coords, $this->rutaImagen, $this->id);
        $prepare->execute();
    }

    public function delete($id)
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("DELETE FROM escenarios WHERE id=?");
        $prepare->bind_param('i', $id);
        $prepare->execute();
    }
}
