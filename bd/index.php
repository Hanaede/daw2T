<?php
/**
 * 
 * 
 * 
 */

include("lib/function.php");

session_start();
if(!isset($_SESSION["usuario"])){
    $_SESSION["usuario"] = ["auth" => false,
                            "nombreUs" => "invitado"];
}

$db = conectaDB();

//Consultas no preparadas
/*$nombre = "paco";
$sql = "insert into perros(nombre) values('" . $nombre . "')";

if($db -> query($sql)) {
    echo "Bien hecho";
}else {
    echo "Mal hecho";
}*/

//Consulta preparada
/*$sql = "SELECT * FROM perros";
$consulta = $db -> prepare($sql);
$consulta -> execute();
$resultado = $consulta -> fetchAll();
foreach ($resultado as $valor) {
    echo $valor['nombre'] . "<br/>";   
}*/

//Consulta preparada con datos de usuario que es necesario evitar
//NO DEBEMOS INCLUIR EN LA CONSULRA ENTRADA DE USUARIO

//Definicion de variables para la vista $data
$data["mascotas"] = [];
$data["usuario"] = ["auth" => false,
                    "nombreUs" => "invitado"];

$campo = clearData($_POST['busqueda'] ?? '');
$valBusqueda = $campo;
$sql = "SELECT * FROM perros WHERE nombre LIKE :nombre OR raza LIKE :raza";

$consulta = $db -> prepare($sql);
$aParametros = array(":nombre" => "$campo%",
                     ":raza" => "$campo%");
$consulta -> execute($aParametros);
$data["mascotas"] = $consulta -> fetchAll(); //Almacenamos los datos en un array bidireccional indexado asociativo
$numeroRegistros = $consulta -> rowCount();

if(isset($_POST["login"])){
    $usuario = clearData($_POST['usuario'] ?? '');
    $pass = clearData($_POST['passwd'] ?? '');
    $sql = "SELECT * FROM usuario WHERE usuario = :usuario AND pass = :pass";
    $consulta = $db -> prepare($sql);
    $aParametros = array(":usuario" => $usuario,
                         ":pass" => $pass);
    $consulta -> execute($aParametros);
    //$resultado es un array indexado asociativo con un solo registro como mucho
    $resultado = $consulta -> fetchAll();
    //Numero de filas que tiene la tabla usuarios (0 no esta / 1 esta)
    $RegistroUsuario = $consulta -> rowCount();

    if($RegistroUsuario == 1){
        $_SESSION["usuario"]["auth"] = true;
        $_SESSION["usuario"]["nombreUs"] = $resultado[0]["nombre"];

    }
    $data["usuario"] = $_SESSION["usuario"];
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
    <header>
        <h1>GESTION DE MASCOTAS</h1>
        <div>
            <?php
                echo "<p>Bienvenido, " . $data["usuario"]["nombreUs"] . "</p>";

                if($data["usuario"]["auth"]) {
                    echo '<a href="./cierre_sesion.php">Cierre Sesion</a>';
                }else {
                    include("./view/login_view.php");
                }
            ?>
        </div>
    </header>
    <form action="" method="POST">
        <label for="">Busqueda:</label>
        <input type="text" name="busqueda" value="<?php echo $valBusqueda ?>">
        <input type="submit" name="buscar" value ="Buscar">
    </form>
    <form action="aniadir.php" method="POST">
            <input type="submit" name="+" value ="Añadir">
    </form>
    <?php 
        if($data["usuario"]["auth"]){
            include("./view/aniadir_view.php");
        }

    ?>
    <?php
        echo "<h3>Listado de Perros: $numeroRegistros</h3>";
        if(!$data["mascotas"]) {
            echo "Consulta vacía";
        }else {
            //$Data array cargado con los datos a mostrar
            foreach ($data["mascotas"] as $valor) {
                echo "Nombre: " . $valor['nombre'] . " - ";
                echo "Peso: " . $valor['peso'] . " - "; 
                echo "Raza: " . $valor['raza'] . " ";
                if($data["usuario"]["auth"]){
                    echo "<a href='./del.php?id=$valor[id]'>Borrar</a> <br/>";
                } else {
                    echo "<br/>";
                }
            }
        }
    ?>
</body>
</html>