<?php
namespace App\Models;
require_once('DBAbstractModel.php');


class Examenes extends DBAbstractModel
{
    private static $instancia;

    // Patrón singleton, no puedo tener dos objetos de la clase Usuarios
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    // Método para evitar la clonación del objeto
    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    //Atributos
    private $id;
    private $id_asignatura;
    private $titulo;
    private $fecha;

    //setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdAsignatura($id_asignatura)
    {
        $this->id_asignatura = $id_asignatura;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    //getters

    public function getId()
    {
        return $this->id;
    }
    public function getIdAsignatura()
    {
        return $this->id_asignatura;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getFecha()
    {
        return $this->fecha;
    }

    //Set
    public function set(){}
    //Get
    public function get(){
        $this->query = "SELECT * FROM examenes";
        $this->get_results_from_query();
        return $this->rows;
    }
    //Edit
    public function edit(){}
    //Delete
    public function delete(){}
}