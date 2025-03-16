<?php
/**
 * 
 * Funcion para eliminar un dato
 * 
 * @author
 */

 session_start();



 if(!$_SESSION["usuario"]["auth"]){
    header("location: index.php?error=1");
 }
 include("lib/function.php");

    function elminarDato(){
        $db = conectaDB();
        $id = $_GET["id"];
        $sql = "DELETE FROM perros WHERE id LIKE :id";

        $consulta = $db -> prepare($sql);
        if($consulta -> execute(array(":id" => $id))) {
            header("location: ./index.php");
        }else {
            echo "Perro no borrado";
        }
    }

    elminarDato();
?>