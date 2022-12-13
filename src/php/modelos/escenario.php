<?php
include('../config/conexion.php');


class Escenario
{
    private $conexion;
    public $nombre;
    public $idDificultad;
    public $waypoints;
    public $coords;
    public $rutaImagen;

    public function __construct()
    {
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD) or die("no hay conexion");
        $this->conexion->set_charset('utf8');
    }

    public function getAll()
    {
        $datos = $this->conexion->query("SELECT * FROM escenario"); //prepare cuando sea losotros con filtros
        return $datos;
    }

    public function get($id)
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("SELECT * FROM escenario WHERE id=?");
        $prepare->bind_param('i', $id);
        $prepare->execute();
        $result = $prepare->get_result();
        return $result->fetch_assoc();
    }

    public function add($post, $files) 
    {
        $this->nombre = $post['nombre'];
        $this->idDificultad =  $post['dificultad'];
        $this->waypoints = $post['waypoints'];
        $this->coords = $post['coords'];
        $this->rutaImagen = "../../img/subidas/escenarios/" . $files["nombreImagen"]["name"];
        $archivo = $_FILES["nombreImagen"]["tmp_name"];
        move_uploaded_file($archivo, $this->rutaImagen);


        $conexion = $this->conexion;
        $prepare =  $conexion->prepare("INSERT INTO escenario (nombre, idDificultad, waypoints, coordenadas, nombreImagen) VALUES(?,?,?,?,?)");
        $prepare->bind_param("sisss", $this->nombre, $this->idDificultad, $this->waypoints, $this->coords, $this->rutaImagen);
        $prepare->execute();
        $prepare->close();
    }
    public function update($arrayPost, $arrayFiles, $rutaImagen, $id) //el nombre lo añado cuando creo el objeto escenario
    {
        if (
            isset($arrayPost["nombre"]) && !empty($arrayPost["nombre"])
            && isset($arrayPost["dificultad"]) && !empty($arrayPost["dificultad"])
            && isset($arrayPost["puntos"]) && !empty($arrayPost["puntos"])
            && isset($arrayFiles["nombreImagen"]["name"]) && !empty($arrayFiles["nombreImagen"]["name"])
        ) {

            unlink(realpath($rutaImagen));

            $nombreImagen = $arrayFiles["nombreImagen"]["name"];
            $ruta = "../../img/subidas/escenarios/" . $nombreImagen;
            $archivo = $arrayFiles["nombreImagen"]["tmp_name"];
            $subir = move_uploaded_file($archivo, $ruta);


            $consulta =  $this->mysqli->prepare("UPDATE escenario 
													SET nombre= ?,
													idDificultad= ?,
													waypoints= ?,
                                                    coordenadas=?
													nombreImagen= ?
													WHERE id = ?");
            $consulta->bind_param("sisssi", $arrayPost["nombre"], $arrayPost["velocidadMov"], $arrayPost["puntos"], $ruta, $id);
            $consulta->execute();
            $consulta->close();
            return true;
        } else {
            return false; /* Para controlar los mensajes de alertas */
        }
    }

    public function delete($id)
    {
        $prepare = $this->conexion->prepare("DELETE FROM escenario WHERE id = ?");
        $prepare->bind_param("i", $id);
        $prepare->execute();
        $prepare->close();
        return true;
    }
}
