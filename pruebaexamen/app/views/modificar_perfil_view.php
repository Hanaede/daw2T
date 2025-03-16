<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Perfil del Usuario</title>
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
            <button><a href="/perfil/">Ver perfil</a></button>
            <button><a href="/examen/">Realizar examen</a></button>
            <button><a href="/eliminarUsuario/">Eliminar ususario</a></button>

        <?php endif; ?>
    </nav>

    <h1>Modificar Perfil del Usuario</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['usuario'][0]['nombre'] ?? ''); ?>">
        <span><?php echo $data['msjErrorNombre'] ?? ''; ?></span><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($data['usuario'][0]['apellidos'] ?? ''); ?>">
        <span><?php echo $data['msjErrorApellidos'] ?? ''; ?></span><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['usuario'][0]['email'] ?? ''); ?>">
        <span><?php echo $data['msjErrorEmail'] ?? ''; ?></span><br>

        <label for="resumen_perfil">Resumen de perfil:</label>
        <textarea id="resumen_perfil" name="resumen_perfil"><?php echo htmlspecialchars($data['usuario'][0]['resumen_perfil'] ?? ''); ?></textarea>
        <span><?php echo $data['msjErrorResumenPerfil'] ?? ''; ?></span><br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto">
        <span><?php echo $data['msjErrorFoto']; ?></span><br>
        <!-- <?php //if (!empty($data['usuario']['foto'])): ?>
            <img src="/uploads/<?php// echo htmlspecialchars($data['usuario'][0]['foto']); ?>" alt="Foto de perfil" width="100"><br>
        <?php //endif; ?> -->

        <button type="submit">Guardar cambios</button>
    </form>

</body>
</html>