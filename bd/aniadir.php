<?php
/**
 * 
 * Funcion para añadir un dato
 * 
 * @author
 */

include("lib/function.php");

if(isset($_POST['aniadir'])) {
    $db = conectaDB();

    $nombre = clearData($_POST['nombre'] ?? '');
    $peso = clearData($_POST['peso'] ?? 4);
    $raza = clearData($_POST['raza'] ?? '');

    $sql = "INSERT INTO perros(nombre, peso, raza) VALUES (:nombre, :peso, :raza)";

    $consulta = $db -> prepare($sql);
    $aParametros = array(":nombre" => $nombre,
                         ":peso" => $peso,
                         ":raza" => $raza);
    $consulta -> execute($aParametros);
    $resultado = $consulta -> fetchAll(); //Almacenamos los datos en un array bidireccional indexado asociativo

    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas SQL</title>
</head>
<body>
    <h1>GESTION DE MASCOTAS</h1>
    
    <h3>Nueva Mascota</h3>

    <form action="" method="POST">
        <label for="">Nombre: </label>
        <input type="text" name="nombre" value=""><br/>
        <label for="">Peso: </label>
        <input type="text" name="peso" value=""><br/>
        <label for="">Raza: </label>
        <input type="text" name="raza" value=""><br/>
        <input type="submit" name="aniadir" id="Añadir">
    </form>
</body>
</html>