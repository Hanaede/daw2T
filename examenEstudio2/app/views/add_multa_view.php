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
    <!--Añadir multas-->
    <h2>Añadir multas</h2>
    <!--Nombre del agente-->
    <p>Nombre del agente: <?php echo $data['nombreagente']; ?></p>

    <!--Formulario para añadir multas-->
    <form action="" method="post">
        <input type="text" name="matricula" placeholder="Matrícula" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="date" name="fecha" required>
        <select name="conductor" required>
            <option value="">Selecciona un conductor</option>
            <?php foreach ($data['conductores'] as $conductor) : ?>
                <option value="<?php echo $conductor['id']; ?>"><?php echo $conductor['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
        <!--radio button para el tipo de sanción -->
        <input type="radio" name="tiposancion" value="1" required>Leve
        <input type="radio" name="tiposancion" value="2" required>Grave
        <input type="radio" name="tiposancion" value="3" required>Muy grave
        
        <button type="submit">Añadir multa</button>
    </form>
</body>
</html>