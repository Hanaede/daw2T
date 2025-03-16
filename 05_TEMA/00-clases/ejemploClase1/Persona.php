<?php
/**
 * 
 * Clase Persona
 * @author KIKE MJ
 */


 class Persona 
 {
    private $_nombre;
    private $_apellido1;
    private $_apellido2;

    /**
     *  __construct de la clase
     * @param mixed $nombre
     * @param mixed $apellido1
     * @param mixed $apellido2
     */
    public function __construct($nombre, $apellido1, $apellido2) 
    {
      $this->_nombre = $nombre; // $this es una pseudovariable para referenciar el objeto.
      $this->_apellido1 = $apellido1;
      $this->_apellido2 = $apellido2;
    }

    /**
     * Función que devuelve el nombre y los apellidos de la persona
     * @return string
     */
    public function nombre()
    {
      return $this->_nombre . $this->_apellido1 . $this->_apellido2;
    }

    /**
     * Función que devuelve Hola mundo
     * @return void
     */
    public function saludo() {
      echo "Hola mundo";
    }
 }