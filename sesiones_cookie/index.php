<?php
session_start();

// Si ya hay una sesión activa, redirigir a la página de bienvenida
if (isset($_SESSION['usuario'])) {
    header("Location: bienvenida.php");
    exit();
}

// Si hay una cookie, establecer la sesión automáticamente
if (isset($_COOKIE['usuario'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    header("Location: bienvenida.php");
    exit();
}

$usuario_guardado = isset($_COOKIE['usuario']) ? $_COOKIE['usuario'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="procesar.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario_guardado); ?>" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <label>
            <input type="checkbox" name="recordar" value="1"> Recordarme
        </label>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
