<?php
/**
 * 
 * Clase Alumno
 * @author KIKE MJ
 * 
 */
require_once "Persona.php";

class Alumno extends Persona
{
    private $_nie;
    public function saludo() {
        echo parent::saludo();
        echo " Soy un alumno";
    }
}