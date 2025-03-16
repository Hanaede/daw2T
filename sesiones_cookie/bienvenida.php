<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
    <a href="cerrar.php">Cerrar sesión</a>
</body>
</html>
