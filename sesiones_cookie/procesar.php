<?php
session_start();

// Simulación de credenciales correctas (en un caso real, se consultaría una base de datos)
$usuario_correcto = "admin";
$password_correcta = "1234";

if ($_POST['usuario'] === $usuario_correcto && $_POST['password'] === $password_correcta) {
    $_SESSION['usuario'] = $_POST['usuario']; // Guardamos el usuario en la sesión

    // Si el usuario marca "Recordarme", guardamos su nombre en una cookie por 7 días
    if (isset($_POST['recordar'])) {
        setcookie("usuario", $_POST['usuario'], time() + (7 * 24 * 60 * 60), "/");
    }

    header("Location: bienvenida.php");
    exit();
} else {
    echo "Usuario o contraseña incorrectos. <a href='index.php'>Intentar de nuevo</a>";
}
?>
