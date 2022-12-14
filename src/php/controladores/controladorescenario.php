<?php
require_once('../modelos/escenario.php');

class ControladorEscenario
{
    private $escenario;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->escenario = new Escenario();
    }

    /**
     * Le pide al modelo todos los escenarios
     */
    public function getEscenarios()
    {
        return $this->escenario->getAll();
    }
    /**
     * Pido al modelo el escenario que tenga el id que entra por parámetro
     * @param {Int} $id id del escenario a obtener
     */
    public function getEscenario($id)
    {
        $fila = $this->escenario->get($id);
        return $fila;
    }
    /**
     * Le digo al modelo que borre el escenario con id que entra por parámetro y 
     * me redirige de nuevo a la vista para recargarla si lo ha hecho bien
     * @param {Int} $id id del escenario a borrar
     */
    public function borrarEscenario($id)
    {
        if ($this->escenario->delete($id))
            header("Location: listaescenarios.php");
    }
    /**
     * Le pido al modelo que modifique con los datos que entran por parámetros
     * @param {Array} $arrayPost Array con los datos enviados por el formulario en $_POST.
     * @param {Array} $arrayFiles Array con los datos de un fichero (name, tmp_name, error...).
     * @param {Int} $id id del escenario a editar
     */
    public function updateEscenario($arrayPost, $arrayFiles, $id)
    {
        $this->escenario->update($arrayPost, $arrayFiles, $id);
        header('Location: listaescenarios.php');
    }
    /**
     * Le pido al modelo que añada a la base de datos un escenario nuevo con los datos que me entran por parámetros
     * @param {Array} $post Array con los datos enviados por el formulario en $_POST.
     * @param {Array} $files Array con los datos de un fichero (name, tmp_name, error...).
     */
    public function addEScenario($post, $files)
    {
        $this->escenario->add($post, $files);
        header('Location: listaescenarios.php');
    }
}
