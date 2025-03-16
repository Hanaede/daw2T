<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
</head>
<body>
    <nav>
        <button><a href="/">Vista principal</a></button>
        <button><a href="/logout/">Cerrar sesión</a></button>
    </nav>

    <h1>Perfil de Usuario</h1>
    <!--<?php //var_dump($data['usuario']); ?>-->
    <?php if (!empty($data['usuario'])): ?>
        <div>
            <?php if (!empty($data['usuario']['foto'])): ?>
                <img src="/public/img/<?php echo htmlspecialchars($data['usuario']['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($data['usuario']['nombre']); ?>" style="width:100px;height:100px;">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($data['usuario']['nombre']); ?></h2>
            <h3>Apellidos: <?php echo htmlspecialchars($data['usuario']['apellidos']); ?></h3>
            <h3>Email: <?php echo htmlspecialchars($data['usuario']['email']); ?></h3>
        </div>
        <h2>Publicaciones</h2>
        <?php if (!empty($data['publicaciones'])): ?>
            <ul>
                <?php foreach ($data['publicaciones'] as $publicacion): ?>
                    <li>
                        <h3>Título: <?php echo htmlspecialchars($publicacion['titulo']); ?></h3>
                        <p>Contenido: <?php echo htmlspecialchars($publicacion['contenido']); ?></p>
                        <?php if (!empty($publicacion['imagen'])): ?>
                            <img src="/public/img/<?php echo htmlspecialchars($publicacion['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($publicacion['titulo']); ?>" style="width:100px;height:100px;">
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay publicaciones.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No se ha encontrado el usuario.</p>
    <?php endif; ?>
</body>
</html>