<?php

namespace App\Models;
require_once('DBAbstractModel.php');

class Notas extends DBAbstractModel
{
    private static $instancia;

    // Patrón singleton, no puedo tener dos objetos de la clase Habilidades
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

    //Atributos de la clase
    private $id;
    private $id_usuario;
    private $id_examen;
    private $nota;
    private $fecha_realizacion;

    //Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }
    public function setIdExamen($id_examen)
    {
        $this->id_examen = $id_examen;
    }
    public function setNota($nota)
    {
        $this->nota = $nota;
    }
    public function setFechaRealizacion($fecha_realizacion)
    {
        $this->fecha_realizacion = $fecha_realizacion;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getIdExamen()
    {
        return $this->id_examen;
    }
    public function getNota()
    {
        return $this->nota;
    }
    public function getFechaRealizacion()
    {
        return $this->fecha_realizacion;
    }

    //Set
    public function set() {
        $fecha = new \DateTime();
        $this->query = "INSERT INTO notas (id_usuario, id_examen, nota, fecha_realizacion) VALUES (:id_usuario, :id_examen, :nota, :fecha_realizacion)";
        $this->parametros['id_usuario'] = $this->id_usuario;
        $this->parametros['id_examen'] = $this->id_examen;
        $this->parametros['nota'] = $this->nota;
        $this->parametros['fecha_realizacion'] = $fecha->format('Y-m-d H:i:s');
        $this->get_results_from_query();
    }

    //Get by user ID
    public function getByUserId($id_usuario) {
        $this->query = "SELECT * FROM notas WHERE id_usuario = :id_usuario";
        $this->parametros['id_usuario'] = $id_usuario;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get($id = ''){
        $this->query = "SELECT * FROM notas WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if(count($this->rows) == 1){
            $this->mensaje = 'Trabajo encontrado';
        }else{
            $this->mensaje = 'Trabajo no encontrado';
        }
        return $this->rows;
    }

    public function edit() {}
    public function delete() {}
}