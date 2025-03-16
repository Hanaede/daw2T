<?php
/**
 * 
 * Documentacion de la clase persona
 * 
 * 
 */

 namespace App\Models;


 class Persona
 {
    private $_nombre;
    private $_apellido1;
    private $_apellido2;

    public function __construct($nombre, $apellido1, $apellido2)
    {
        $this->_nombre = $nombre; // $this es una pseudo variable
        $this->_apellido1 = $apellido1;
        $this->_apellido2 = $apellido2;
    }

    /**
     * 
     * Funcion que devuelve el nombre completo
     * 
     * @return string
     * 
     */
    public function nombre() {
        return $this->_nombre . " " . $this->_apellido1 . " " .  $this->_apellido2;
    }

    /**
     * 
     * Funcion que devuelve hola mundo
     * 
     * @return void
     * 
     */
    public function Saludo(){
        echo "Hola Mundo";
    }
 }

?>