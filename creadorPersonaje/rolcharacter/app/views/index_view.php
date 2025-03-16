<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personajes</title>
    <style>
        body {
            background-color: #1f1f1f;
            font-family: Arial, sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h1 {
            color: #f39c12;
        }
        .personaje {
            background-color: #333;
            border: 1px solid #444;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            text-align: center;
        }
        .personaje img {
            max-width: 100%;
            border-radius: 10px;
        }
        .personaje h2 {
            color: #f39c12;
        }
        .personaje p {
            margin: 5px 0;
        }
        .habilidades {
            margin-top: 10px;
            text-align: left;
        }
        .habilidad {
            background-color: #444;
            border: 1px solid #555;
            border-radius: 5px;
            padding: 10px;
            margin: 5px 0;
        }
        button {
            background-color: #f39c12;
            border: none;
            border-radius: 5px;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        button a {
            color: #fff;
            text-decoration: none;
        }
        button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>

<?php
if (strlen($_SESSION['id']) == 0) {
    ?>
    <button><a href="/add">Registrar</a></button>
    <button><a href="/login/">Iniciar sesión</a></button>
    <button><a href="/">Vista principal</a></button>
<?php
} else {
    ?>
    <button><a href="/logout/">Cerrar sesión</a></button>
    <button><a href="/">Vista principal</a></button>
    <button><a href="/crearHabilidad/">Crear habilidad</a></button>
    <button><a href="/perfil/">Ver perfil</a></button>
    <?php
    // var_dump($_SESSION['id']);
    ?>
    <button><a href="/eliminarPersonaje/<?= htmlspecialchars($_SESSION['id']) ?>">Eliminar personaje</a></button>
<?php
}
?>
<h1>Lista de Personajes</h1>
<?php if (!empty($data['personajes'])): ?>
    <?php foreach ($data['personajes'] as $personaje): ?>
        <div class="personaje">
            <img src="/public/img/<?= htmlspecialchars($personaje['foto'] ?? 'default.jpeg') ?>" alt="Foto de <?= htmlspecialchars($personaje['nombre'] ?? 'Desconocido') ?>">
            <h2><?= htmlspecialchars($personaje['nombre'] ?? 'Desconocido') ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($personaje['email'] ?? 'Desconocido') ?></p>
            <p><strong>Clase:</strong> <?= htmlspecialchars($personaje['clase'] ?? 'Desconocido') ?></p>
            <p><strong>Raza:</strong> <?= htmlspecialchars($personaje['raza'] ?? 'Desconocido') ?></p>
            <p><strong>Armas:</strong> <?= htmlspecialchars($personaje['armas'] ?? 'Desconocido') ?></p>
            <div class="habilidades">
                <h3>Habilidades:</h3>
                <?php if (!empty($personaje['habilidades'])): ?>
                    <?php foreach ($personaje['habilidades'] as $habilidad): ?>
                        <div class="habilidad">
                            <p><strong>Nombre:</strong> <?= htmlspecialchars($habilidad['nombre_habilidad'] ?? 'Desconocido') ?></p>
                            <p><strong>Descripción:</strong> <?= htmlspecialchars($habilidad['descripcion'] ?? 'Desconocido') ?></p>
                            <p><strong>Elemento:</strong> <?= htmlspecialchars($habilidad['elemento'] ?? 'Desconocido') ?></p>
                            <p><strong>Nivel:</strong> <?= htmlspecialchars($habilidad['nivel_habilidad'] ?? 'Desconocido') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay habilidades registradas.</p>
                <?php endif; ?>
            </div>
            <?php if (isset($personaje['personaje_id']) && $_SESSION['id'] == $personaje['personaje_id']): ?>
                <?php if ($personaje['visible'] == 0): ?>
                    <button><a href="/cambiarVisibilidadPerfil/">Visibilizar perfil</a></button>
                <?php else: ?>
                    <button><a href="/cambiarVisibilidadPerfil/">No visibilizar perfil</a></button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay personajes registrados.</p>
<?php endif; ?>
</body>
</html>