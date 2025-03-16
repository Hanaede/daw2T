<?php
/**
 * 6 colores
 * formulario y sesiones
 * Hacer constantes con los colores
 * Genera 4 colores ocultos la máquina
 * Luego mostramos dos columnas con aciertos en la posición corecta y los que hay pero en posición incorrecta
 * 4 columnas y 6 filas
 * Juego Mster mind colores en php
 * author: by @kike
 */

// Definimos los colores que sean constantes en un array 
define('COLORES', ['Red', 'Green', 'Blue', 'Yellow', 'Orange', 'Purple']);
// Inicializamos las variables de sesión
session_start();
if (!isset($_SESSION['colores'])) {
    $_SESSION['colores'] = [];
    for ($i = 0; $i < 4; $i++) {
        $_SESSION['colores'][] = COLORES[rand(0, 5)];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastermind</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    echo "<h1>Mastermind</h1>";
    echo "<h2>Colores disponibles: " . implode(', ', COLORES) . "</h2>";

    //Creación de la tabla de colores con un formulario
    echo "<form method='post'>";
    for ($i = 0; $i < 6; $i++) {
        echo "<div>";
        for ($j = 0; $j < 4; $j++) {
            $class = '';
            if (isset($_POST['colores'][$i][$j])) {
                $color = $_POST['colores'][$i][$j];
                if ($color == $_SESSION['colores'][$j]) {
                    $class = 'correcto';
                } elseif (in_array($color, $_SESSION['colores'])) {
                    $class = 'en-fila';
                } else {
                    $class = 'incorrecto';
                }
            }
            echo "<input type='text' name='colores[$i][$j]' value='" . (isset($_POST['colores'][$i][$j]) ? $_POST['colores'][$i][$j] : '') . "' class='$class'>";
        }
        echo "<input type='submit' value='Validar'>";
        echo "</div>";
    }

//Comprobamos con el botón validar cuantas posiciones hay correctas, cuántas están en la fila pero en posición incorrecta y cuábntas
    if (isset($_POST['colores'])) {
        foreach ($_POST['colores'] as $fila => $colores) {
            $aciertos = 0;
            $enFila = 0;
            $errores = 0;
            foreach ($colores as $posicion => $color) {
                if ($color == $_SESSION['colores'][$posicion]) {
                    $aciertos++;
                } elseif (in_array($color, $_SESSION['colores'])) {
                    $enFila++;
                } else {
                    $errores++;
                }
            }
            echo "<div>Aciertos: $aciertos, Aciertos en posición incorrecta: $enFila, Errores: $errores</div>";
        }
    }

    
    var_dump($_SESSION['colores']);
    ?>
</body>
</html>