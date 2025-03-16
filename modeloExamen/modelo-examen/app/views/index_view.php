<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo Examen</title>
</head>
<body>
    <nav>
        <?php if (strlen($_SESSION['id']) == 0): ?>
            <button><a href="/add">Registrar</a></button>
            <button><a href="/">Vista principal</a></button>
            <form action="/login/" method="post">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
 
        <?php else: ?>
            <button><a href="/logout/">Cerrar sesión</a></button>
            <button><a href="/">Vista principal</a></button>
            <button><a href="/perfil/">Ver perfil</a></button>
        <?php endif; ?>
    </nav>

    <div>
        <!--
        <?php
            //var_dump($data['usuarios']);
        ?>
        -->
        <?php if (!empty($data['usuarios'])): ?>
      
            <?php foreach ($data['usuarios'] as $usuario): ?>
                <?php if (!empty($usuario['foto'])): ?>
                    <img src="/public/img/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($usuario['nombre']); ?>" style="width:100px;height:100px;">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
                <h3>Apellidos: <?php echo htmlspecialchars($usuario['apellidos']); ?></h3>
                <h3>Email: <?php echo htmlspecialchars($usuario['email']); ?></h3>
     
                <?php if (!empty($usuario['publicaciones'])): ?>
                    <ul>
                        <?php foreach ($usuario['publicaciones'] as $publicacion): ?>
                            <li>Título: <?php echo htmlspecialchars($publicacion['titulo']); ?></li>
                            <li>Contenido: <?php echo htmlspecialchars($publicacion['contenido']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay publicaciones.</p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se han encontrado usuarios.</p>
        <?php endif; ?>
    </div>
</body>
</html>