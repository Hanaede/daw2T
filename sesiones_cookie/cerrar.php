<?php
session_start();
session_destroy();

// Eliminar la cookie si existe
setcookie("usuario", "", time() - 3600, "/");

header("Location: index.php");
exit();
?>
