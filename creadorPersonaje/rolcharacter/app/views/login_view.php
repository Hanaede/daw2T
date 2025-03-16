<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/login_view.css">
    <title>Login</title>
</head>
<body>
    </nav>
    <h1 class="titulo">¡BIENVENIDO!</h1>
    <div class="container">
        <div class="login-card">
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="email" placeholder="Email" value="" required>
                <input type="password" name="contrasena" placeholder="Contraseña" value="" required>
                <button type="submit" name="login" value="login">Iniciar sesión</button>
                <button type="button"><a href="/">Volver</a></button>
            </form>
            <?php
            if (isset($data['error'])) {
                echo '<p class="error-message">' . htmlspecialchars($data['error']) . '</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

