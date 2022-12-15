<?php
include('../config/conexion.php');
/**
 * Clase que contiene el Modelo de Escenario
 */
class Escenario
{
    private $conexion;
    public $nombre;
    public $idDificultad;
    public $waypoints;
    public $coords;
    public $rutaImagen;

    /**
     *  Constructor del modelo que contiene la conexion con el servidor de base de datos
     */
    public function __construct()
    {
        $this->conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD) or die("no hay conexion");
        $this->conexion->set_charset('utf8');
    }
    /**
     * Ejecuta una consulta para traer los escenarios
     * @return {array} Array con todos los escenarios
     */
    public function getAll()
    {
        $datos = $this->conexion->query("SELECT * FROM lp_escenario"); //prepare cuando sea losotros con filtros
        return $datos;
    }
    /**
     * Devuelve los escenarios que contengan el $id. En éste caso, sólo encontrará uno ya que es clave única
     * @param {int} $id Número que utilizo en la consulta para obtener los datos
     * @return {array} Devuelve un array con los datos que tengan el id que entra por parámetro
     */
    public function get($id)
    {
        $conexion = $this->conexion;
        $prepare = $conexion->prepare("SELECT * FROM lp_escenario WHERE id=?");
        $prepare->bind_param('i', $id);
        $prepare->execute();
        $result = $prepare->get_result();
        return $result->fetch_assoc();
    }
    /**
     * Añade un escenario a la BBDD 
     * @param {array} $post Los datos que tengo $_POST al mandar el formulario
     * @param {array} $files Datos que tengo $_FILES al mandar el formulario
     * @return {bool} $ok devuelve true si se ha ejecutado correctamente
     */
    public function add($post, $files)
    {
        $this->nombre = $post['nombre'];
        $this->idDificultad =  $post['select'];
        $this->waypoints = $post['waypoints'];
        $this->coords = $post['coords'];
        $this->rutaImagen = "../../img/subidas/escenarios/" . $files["nombreImagen"]["name"];
        $archivo = $_FILES["nombreImagen"]["tmp_name"];
        move_uploaded_file($archivo, $this->rutaImagen);


        $conexion = $this->conexion;
        $prepare =  $conexion->prepare("INSERT INTO lp_escenario (nombre, idDificultad, waypoints, coordenadas, nombreImagen) VALUES(?,?,?,?,?)");
        $prepare->bind_param("sisss", $this->nombre, $this->idDificultad, $this->waypoints, $this->coords, $this->rutaImagen);
        $ok = $prepare->execute();
        $prepare->close();

        return $ok;
    }
    /**
     * Modifico el escenario que tiene el id que me entra por parámetro con los datos del formulario 
     * @param {array} $post Los datos que tengo $_POST al mandar el formulario
     * @param {array} $files Datos que tengo $_FILES al mandar el formulario
     * @param {int} $id dato del escenario a modificar 
     * @return {bool} $ok devuelve true si se ha ejecutado correctamente
     */
    public function update($post, $files, $nombreimageneliminar, $id) //el nombre lo añado cuando creo el objeto escenario
    {
        unlink(realpath($nombreimageneliminar));

        $nombreimagenNueva = $files["nombreImagen"]["name"];
        $rutaImagen = "../../img/subidas/escenarios/" . $nombreimagenNueva;
        $archivo = $files["nombreImagen"]["tmp_name"];
        move_uploaded_file($archivo, $rutaImagen);



        $conexion = $this->conexion;
        $prepare =  $conexion->prepare("UPDATE lp_escenario SET nombre= ?, idDificultad= ?, waypoints= ?, coordenadas=?, nombreImagen= ? WHERE id = ?");
        $prepare->bind_param("sisssi", $post['nombre'], $post['select'], $post['waypoints'], $post['coords'], $rutaImagen, $id);
        $ok = $prepare->execute();
        $prepare->close();

        return $ok;
    }
    /**
     * Borro el escenario con el id que me llega por parámetro
     * @param {int} $id dato del escenario a borrar 
     * @return {bool} $ok devuelve true si se ha ejecutado correctamente
     */
    public function delete($id)
    {
        //primero obtengo la ruta de la imagen para borrarlo
        $nombreimageneliminar = $this->get($id)['nombreImagen'];
        unlink(realpath($nombreimageneliminar));

        $prepare = $this->conexion->prepare("DELETE FROM lp_escenario WHERE id = ?");
        $prepare->bind_param("i", $id);
        $ok = $prepare->execute();
        $prepare->close();
        return $ok;
    }
}
