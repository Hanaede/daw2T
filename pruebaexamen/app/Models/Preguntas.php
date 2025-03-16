<?php
namespace App\Models;
require_once('DBAbstractModel.php');
use App\Models\Examenes;



class Preguntas extends DBAbstractModel
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
    private $id_examen;
    private $enunciado;
    private $opcion_a;
    private $opcion_b;
    private $opcion_c;
    private $opcion_d;
    private $respuesta_correcta;


    //setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdExamen($id_examen)
    {
        $this->id_examen = $id_examen;
    }
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;
    }
    public function setOpcionA($opcion_a)
    {
        $this->opcion_a = $opcion_a;
    }
    public function setOpcionB($opcion_b)
    {
        $this->opcion_b = $opcion_b;
    }
    public function setOpcionC($opcion_c)
    {
        $this->opcion_c = $opcion_c;
    }
    public function setOpcionD($opcion_d)
    {
        $this->opcion_d = $opcion_d;
    }
    public function setRespuestaCorrecta($respuesta_correcta)
    {
        $this->respuesta_correcta = $respuesta_correcta;
    }

    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getIdExamen()
    {
        return $this->id_examen;
    }
    public function getEnunciado()
    {
        return $this->enunciado;
    }
    public function getOpcionA()
    {
        return $this->opcion_a;
    }
    public function getOpcionB()
    {
        return $this->opcion_b;
    }
    public function getOpcionC()
    {
        return $this->opcion_c;
    }
    public function getOpcionD()
    {
        return $this->opcion_d;
    }
    public function getRespuestaCorrecta()
    {
        return $this->respuesta_correcta;
    }

    //Set
    public function set(){}
    //Get  
    public function get($id = ""){

    }
    //Edit
    public function edit(){}
    //Delete
    public function delete(){}

    public function getByExamen($id_examen){
        $this->query = "SELECT * FROM preguntas WHERE id_examen = :id_examen";
        $this->parametros['id_examen'] = $id_examen;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Get by ID
    public function getById($id)
    {
        $this->query = "SELECT * FROM preguntas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows[0];
    }
}