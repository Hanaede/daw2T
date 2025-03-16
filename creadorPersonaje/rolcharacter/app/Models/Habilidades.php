<?php

namespace App\Models;
require_once('DBAbstractModel.php');

class Habilidades extends DBAbstractModel
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

    // Propiedades
    private $id;
    private $nombre_habilidad;
    private $descripcion;
    private $elemento;
    private $visible;
    private $personaje_id;
    private $created_at;
    private $updated_at;
    private $nivel_habilidad;

    // Setters
    private function setId($id)
    {
        $this->id = $id;
    }

    public function setNombreHabilidad($nombre_habilidad)
    {
        $this->nombre_habilidad = $nombre_habilidad;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setElemento($elemento)
    {
        $this->elemento = $elemento;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function setPersonajeId($personaje_id)
    {
        $this->personaje_id = $personaje_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function setNivelHabilidad($nivel_habilidad)
    {
        $this->nivel_habilidad = $nivel_habilidad;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNombreHabilidad()
    {
        return $this->nombre_habilidad;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getElemento()
    {
        return $this->elemento;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function getPersonajeId()
    {
        return $this->personaje_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getNivelHabilidad()
    {
        return $this->nivel_habilidad;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    // Métodos CRUD
    public function set() {
        $this->query = "INSERT INTO habilidades (nombre_habilidad, descripcion, elemento, visible, personaje_id, nivel_habilidad) VALUES (:nombre_habilidad, :descripcion, :elemento, :visible, :personaje_id, :nivel_habilidad)";
        $this->parametros['nombre_habilidad'] = $this->nombre_habilidad;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['elemento'] = $this->elemento;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['personaje_id'] = $this->personaje_id;
        $this->parametros['nivel_habilidad'] = $this->nivel_habilidad;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad añadida';
    }
    
    public function get($id = ''){

    }
    public function edit($id = '') {
        $this->query = "UPDATE habilidades SET nombre_habilidad = :nombre_habilidad, descripcion = :descripcion, elemento = :elemento, visible = :visible, personaje_id = :personaje_id, nivel_habilidad = :nivel_habilidad WHERE id = :id";
        $this->parametros['nombre_habilidad'] = $this->nombre_habilidad;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['elemento'] = $this->elemento;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['personaje_id'] = $this->personaje_id;
        $this->parametros['nivel_habilidad'] = $this->nivel_habilidad;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad modificada';
  
    }
    public function delete($id='') {
  
    }

    public function getByPersonajeId($personaje_id) {
        $this->query = "SELECT * FROM habilidades WHERE personaje_id = :personaje_id";
        $this->parametros['personaje_id'] = $personaje_id;
        $this->get_results_from_query();
        return $this->rows;
    }
    
}