<?php

namespace App\Models;

class Animales extends DBAbstractModel{
    private static $instancia;

    // Patron singleton, no puedo tener dos objetos de la clase mascotas
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }

    public function __construct(){}

    private $id;
    private $nombre;
    private $categoria_id;
    private $raza;
    private $foto;

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setCategoria_id($categoria_id){
        $this->categoria_id = $categoria_id;
    }

    public function setRaza($raza){
        $this->raza = $raza;
    }

    public function setFoto($foto){
        $this->foto = $foto;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getCategoria_id(){
        return $this->categoria_id;
    }

    public function getRaza(){
        return $this->raza;
    }

    public function getFoto(){
        return $this->foto;
    }

    public function get(){}

    public function set(){}

    public function edit(){}

    public function delete(){}

    public function getMascotasByFilter($filtro){
        $this->query = "SELECT * FROM animales WHERE nombre LIKE '%$filtro%' OR raza LIKE '%$filtro%'";
        $this->parametros['filtro'] = '%'.$filtro.'%';
        $this->get_results_from_query();
        return $this->rows;
    }

}

?>