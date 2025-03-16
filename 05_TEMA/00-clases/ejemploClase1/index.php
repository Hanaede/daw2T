<?php
/**
 * 
 * 
 */

 // Requerimos clase Persona
 require_once "Persona.php";
 require_once "Alumno.php";

 // Creamos un objeto
 $persona = new Persona("Kike ", "Mariño ", "Jiménez");
 
 $persona->saludo();

 echo "<br/>";

 echo $persona->nombre();

 echo "<br/>";

 $alumno = new Alumno("Kike", "Mar", "Jiménez");
 $alumno->saludo();
