<?php
function conectaDB()
{
    try {
        $dsn = "mysql:host=localhost;dbname=mascotas";
        $db = new PDO($dsn, 'kike');
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        return($db);
    }
    catch (PDOException $e) {
        echo "Error conexión";
        exit();
    }
}
