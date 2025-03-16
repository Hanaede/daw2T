<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav>
        <?php if (strlen($_SESSION['id']) == 0): ?>
                <!-- <button><a href="/registro/">Registrar</a></button> -->
                <form action="/" method="post">
                    <input type="usuario" name="usuario" placeholder="Usuario" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Iniciar sesión</button>
                </form>
                <?php else: ?>

                <?php if($_SESSION['perfil'] == 'conductor'): ?>
                    <button><a href="/logout/">Cerrar sesión</a></button>
                    <button><a href="/">Vista principal</a></button>
                    <button><a href="/perfilconductor/">Ver perfil</a></button>
                    <button><a href="/eliminarusuario/">Eliminar Usuario</a></button>
                <?php else: ?>
                    <button><a href="/logout/">Cerrar sesión</a></button>
                    <button><a href="/">Vista principal</a></button>
                    <button><a href="/perfilagente/">Ver perfil</a></button>
                    <button><a href="/eliminarusuario/">Eliminar Usuario</a></button>

                <?php endif; ?>
        <?php endif; ?>
    </nav>
    <!--Pago de multas-->
    <h1>Pagar multas</h1>
    <?php
    foreach ($data['multas'] as $multa) : ?>
        <p>Matricula: <?php echo $multa['matricula']; ?></p>
        <p>Descripcion: <?php echo $multa['descripcion']; ?></p>
        <p>Fecha: <?php echo $multa['fecha']; ?></p>
        <p>Importe: <?php echo $multa['importe']; ?></p>
        <p>Estado: <?php echo $multa['estado']; ?></p>
        <p>Tipo: <?php echo $multa['id_tipo_sanciones']; ?></p>
        <form action="" method="post">
            <button type="submit">Pagar</button>
        </form>
    <?php endforeach; ?>
</body>
</html>