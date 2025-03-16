<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
</head>
<body>
    <nav>
        <?php if (strlen($_SESSION['id']) == 0): ?>
            <button><a href="/add">Registrar</a></button>
            <form action="/login/" method="post">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
            <button><a href="/">Vista principal</a></button>
        <?php else: ?>
            <button><a href="/logout/">Cerrar sesión</a></button>
            <button><a href="/">Vista principal</a></button>
        <?php endif; ?>
    </nav>
    <h1>Registrar Usuario</h1>
    <?php
        // Generar números aleatorios para el captcha
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($data['nombre']) ?>" required>
        <span><?= htmlspecialchars($data['eNombre']) ?></span><br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($data['apellidos']) ?>" required>
        <span><?= htmlspecialchars($data['eApellidos']) ?></span><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
        <span><?= htmlspecialchars($data['eEmail']) ?></span><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <span><?= htmlspecialchars($data['ePassword']) ?></span><br><br>

        <label for="passwordConfirm">Confirmar Contraseña:</label>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required>
        <span><?= htmlspecialchars($data['ePasswordConfirm']) ?></span><br><br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto">
        <span><?= htmlspecialchars($data['eFoto']) ?></span><br><br>

        <h2>Agregar Publicación</h2>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($data['titulo']) ?>"><br><br>

        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido"><?= htmlspecialchars($data['contenido']) ?></textarea><br><br>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen"><br><br>

        <label for="captcha">¿Cuánto es <?= $num1 ?> + <?= $num2 ?>?</label>
        <input type="text" id="captcha" name="captcha" required>
        <span><?= htmlspecialchars($data['eCaptcha']) ?></span><br><br>

        <input type="hidden" name="num1" value="<?= $num1 ?>">
        <input type="hidden" name="num2" value="<?= $num2 ?>">

        <input type="submit" value="Registrar">
    </form>
</body>
</html>