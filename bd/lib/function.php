<?php
/**
 * 
 * FUNCION PARA CONECTARSE A LA BASE DE DATOS
 * 
 * @author
 */

function conectaDB() {
    try {
        $dsn = "mysql:host=localhost;dbname=bd_mascotas";
        $db = new PDO($dsn, 'kike', 'kike'); //Manejo de errores
        $db -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $db -> setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        return($db);
    }catch(PDOException $e) {
        echo "Error conexión";
        exit();
    }
}
