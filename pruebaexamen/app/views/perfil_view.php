<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
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
            <button><a href="/modificarPerfil/">Modificar perfil</a></button>
            <button><a href="/eliminarUsuario/">Eliminar ususario</a></button>

        <?php endif; ?>
    </nav>

    <h1>Perfil del Usuario</h1>
    <h2>Datos del Usuario</h2>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($data['usuario'][0]['nombre'] ?? ''); ?></p>
    <p><strong>Apellidos:</strong> <?php echo htmlspecialchars($data['usuario'][0]['apellidos'] ?? ''); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['usuario'][0]['email'] ?? ''); ?></p>
    <p><strong>Resumen de perfil:</strong> <?php echo htmlspecialchars($data['usuario'][0]['resumen_perfil'] ?? ''); ?></p>
    <p><strong>Foto:</strong> <img src="../uploads/<?php echo htmlspecialchars($data['usuario'][0]['foto'] ?? ''); ?>" alt="Foto de perfil"></p>

    <h2>Notas</h2>
    <?php if (!empty($data['notas'])): ?>
        <ul>
            <?php foreach ($data['notas'] as $nota): ?>
                <li><?php echo htmlspecialchars($nota['nota']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay notas disponibles.</p>
    <?php endif; ?>
</body>
</html>