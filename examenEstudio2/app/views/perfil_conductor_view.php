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
    <h1>Perfil del conductor</h1>
    <!-- <?php var_dump($data['usuario']); ?> -->
    <p>Nombre: <?php echo $data['usuario'][0]['usuario']; ?></p>  

    <!--Mostramos las multas en una tabla-->
    <table>
        <thead>
            <tr>
                <th>Matrticula</th>
                <th>Descripcion</th>
                <th>Fecha</th>
                <th>importe</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['multas'] as $multa) : ?>
                <tr>
                    <td><?php echo $multa['matricula']; ?></td>
                    <td><?php echo $multa['descripcion']; ?></td>
                    <td><?php echo $multa['fecha']; ?></td>
                    <td><?php echo $multa['importe']; ?></td>
                    <td><?php echo $multa['estado']; ?></td>
                    <td><?php
                    if($multa['estado'] == "Pendiente") {
                        echo "<a href='/pagarmultas/".$multa['id']."'>Pagar</a>";
                    }
                    ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

</body>
</html>