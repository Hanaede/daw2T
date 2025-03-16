<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login con CAPTCHA</title>
</head>
<body>
<nav>
    <?php if (empty($_SESSION['id'])): ?>
        <form action="/" method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <label>¿Cuánto es <?php echo $data['num1']; ?> + <?php echo $data['num2']; ?>?</label>
            <input type="number" name="captcha" placeholder="Resultado" required>
            <button type="submit">Iniciar sesión</button>
            <?php if (!empty($data['error'])): ?>
                <p style="color: red;"><?php echo $data['error']; ?></p>
            <?php endif; ?>
        </form>
    <?php else: ?>
        <button><a href="/logout/">Cerrar sesión</a></button>
        <button><a href="/">Vista principal</a></button>
        <?php if ($_SESSION['perfil'] == 'conductor'): ?>
            <button><a href="/perfilconductor/">Ver perfil</a></button>
        <?php else: ?>
            <button><a href="/perfilagente/">Ver perfil</a></button>
        <?php endif; ?>
        <button><a href="/eliminarusuario/">Eliminar Usuario</a></button>
    <?php endif; ?>
</nav>
</body>
</html>
