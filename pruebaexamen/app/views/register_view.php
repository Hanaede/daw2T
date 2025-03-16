<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
        <?php endif; ?>
    </nav>

    <h1>Registro de Usuario</h1>
    <?php
        // Generar números aleatorios para el captcha de suma
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);

        // Generar una cadena aleatoria de 5 letras
        $captcha_letras = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 5);
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($data['nombre']) ?>">
            <span><?= htmlspecialchars($data['eNombre']) ?></span>
        </div>
        <div>
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($data['apellidos']) ?>">
            <span><?= htmlspecialchars($data['eApellidos']) ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>">
            <span><?= htmlspecialchars($data['eEmail']) ?></span>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($data['password']) ?>">
            <span><?= htmlspecialchars($data['ePassword']) ?></span>
        </div>
        <div>
            <label for="passwordConfirm">Confirmar Contraseña:</label>
            <input type="password" id="passwordConfirm" name="passwordConfirm" value="<?= htmlspecialchars($data['passwordConfirm']) ?>">
            <span><?= htmlspecialchars($data['ePasswordConfirm']) ?></span>
        </div>
        <div>
            <label for="resumen_perfil">Resumen de Perfil:</label>
            <textarea id="resumen_perfil" name="resumen_perfil"><?= htmlspecialchars($data['resumen_perfil']) ?></textarea>
            <span><?= htmlspecialchars($data['eResumen_perfil']) ?></span>
        </div>
        <div>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
        </div>
        <div>
            <label for="nota">Nota:</label>
            <input type="text" id="nota" name="nota" value="<?= htmlspecialchars($data['nota']) ?>">
            <span><?= htmlspecialchars($data['eNota']) ?></span>
        </div>
        <div>
            <label for="id_examen">ID Examen:</label>
            <input type="text" id="id_examen" name="id_examen" value="<?= htmlspecialchars($data['id_examen']) ?>">
            <span><?= htmlspecialchars($data['eId_examen']) ?></span>
        </div>
        <div>
            <label for="captcha">¿Cuánto es <?= $num1 ?> + <?= $num2 ?>?</label>
            <input type="text" id="captcha" name="captcha" required>
            <span><?= htmlspecialchars($data['eCaptcha']) ?></span><br><br>

            <input type="hidden" name="num1" value="<?= $num1 ?>">
            <input type="hidden" name="num2" value="<?= $num2 ?>">
        </div>
        <div>
            <label for="captcha_letras">Introduce las siguientes letras: <?= $captcha_letras ?></label>
            <input type="text" id="captcha_letras" name="captcha_letras" required>
            <span><?= htmlspecialchars($data['eCaptchaLetras']) ?></span><br><br>

            <input type="hidden" name="captcha_letras_original" value="<?= $captcha_letras ?>">
        </div>
        <div>
            <button type="submit">Registrar</button>
        </div>
    </form>
</body>
</html>