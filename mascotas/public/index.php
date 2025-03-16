<?php


require_once "../app/config/config.php";
require_once "../app/Model/Mascotas.php";

//Creamos mascotas sin utilizar el patrón de diseño
$mascota1 = new Mascotas();
$mascota2 = new Mascotas();
// Se han creado dos objetos


// Creamos mascotas utilizando el patrón de diseño
$mascota3 = Mascotas::getInstancia();
$mascota4 = Mascotas::getInstancia();

$mascota = Mascotas::getInstancia();

$mascota->setNombre("Dakota");
$mascota->setPeso(20);
$mascota->setRaza("San Bernardo");
$mascota->set(); 

$mascota->get(1);