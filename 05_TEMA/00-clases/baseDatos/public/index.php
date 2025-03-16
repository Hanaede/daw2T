<?php   
//echo "hola mundo";
include("../basicos/lib/functions.php");


// Añade un elemento a perros
//$db = conectaDB();
//$nombre = "Firulais";
//$sql = "insert into perros(nombre) values('". $nombre ."')";
//if($db->query($sql)) {
//    echo "ok";
//} else {
//    echo "no";
//}

// muestra los nombres de los perros
//$db = conectaDB();
//$sql = "SELECT * FROM perros";
//$consulta = $db->prepare($sql);
//$consulta -> execute();
//$resultado = $consulta->fetchAll();
//foreach ($resultado as $valor) {
//    echo $valor['nombre'] . "<br/>";
//}

// Formulario para buscar un dato
//$db = conectaDB();
// NO DEBEMOS INCLUIR EN LA CONSULTA ENTRADA DE YSYARUI
//$campo = $_POST['busqueda'] ?? 'S';
//$sql = "SELECT * FROM perros WHERE nombre LIKE '" . $campo . "%'";
//$consulta = $db ->prepare($sql);
//$consulta ->execute();
//$resultado = $consulta ->fetchAll();
//echo "Listado de Perros <br/>";

//if (!$resultado){
 //   echo "Error en la consulta";
//}

//else {
//    foreach ($resultado as $valor){
//        echo $valor['nombre'] . "<br/>";
//    }
//}

// primera forma de parametrizar
//$db = conectaDB();

// Dos condiciones de búsqueda
//$campo = $_POST['busqueda'] ?? 'C%';
//$peso = $_POST['peso'] ?? 3;
//$sql = "SELECT * FROM perros WHERE nombre LIKE ? AND peso > ?";

//$consulta = $db->prepare($sql);
//$consulta->execute(array($campo,$peso));
//$resultado = $consulta->fetchAll();
//$numeroRegistros = $consulta->rowCount();
//echo "Listado de Perros:$numeroRegistros<br/>";
//if (!$resultado) {
//    echo "Consulta vacía";
//}
//else {
//    foreach ($resultado as $valor) {
//        echo $valor['nombre'];
//        echo $valor['peso']."<br/>";
 //   }
//}


// segunda forma de parametrizar
//$db = conectaDB();

// Dos condiciones de búsqueda
//$campo = $_POST['busqueda'] ?? 'C%';
//$//$sql = "SELECT * FROM perros WHERE nombre LIKE :nombre AND peso > :peso";

//$consulta = $db->prepare($sql);
//$consulta->execute(array(":nombre"=>$campo,":peso"=>$peso));
//$resultado = $consulta->fetchAll();
//$numeroRegistros = $consulta->rowCount();
//echo "Listado de Perros:$numeroRegistros<br/>";
//if (!$resultado) {
//    echo "Consulta vacía";
//}
//else {
 //   foreach ($resultado as $valor) {
//        echo $valor['nombre']." ";
//        echo $valor['peso']."<br/>";
//    }
//}


// segunda forma de parametrizar
$db = conectaDB();

// Dos condiciones de búsqueda
$campo = $_POST['busqueda'] ?? 'P%';
$peso = $_POST['peso'] ?? 'P%';
$raza = $_POST['raza'] ?? 'P%';
$sql = "SELECT * FROM perros WHERE nombre LIKE :nombre OR peso > :peso OR raza LIKE :raza";

$consulta = $db->prepare($sql);
$consulta->execute(array(":nombre"=>$campo,":peso"=>$peso, ":raza"=>$raza));
$resultado = $consulta->fetchAll();
$numeroRegistros = $consulta->rowCount();
echo "Listado de Perros:$numeroRegistros<br/>";
if (!$resultado) {
    echo "Consulta vacía";
}
else {
    foreach ($resultado as $valor) {
        echo $valor['nombre']." ";
        echo $valor['peso']." ";
        echo $valor['raza']."<br/>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>GESTIÓN DE MASCOTAS</h1>
        <div>
            <?php
                if ($data['auth']) {
                    echo "<p>Bienvenido," . $data['usuario']['nombreUs'] . "</p>";
                } else {
                    include("login_view.php");
                }
            ?>
        </div>
    </header>
    <form method="post">
        <input type="text" name="busqueda" id="busqueda" value="">
        <input type="text" name="peso" id="busqueda" value="">
        <input type="text" name="raza" id="busqueda" value="">
        <input type="submit" name="enviar" value="enviar">
        <a href=""></a>
    </form>
</body>
</html>