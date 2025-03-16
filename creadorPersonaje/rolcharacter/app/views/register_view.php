<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Personaje</title>
</head>
<body>
    <h1>Registrar Personaje</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre del Personaje:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $data['nombre'] ?>" required>
        <span><?= $data['eNombre'] ?></span><br><br>

        <label for="email">Email del Personaje:</label>
        <input type="email" id="email" name="email" value="<?= $data['email'] ?>" required>
        <span><?= $data['eEmail'] ?></span><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required value="<?php echo htmlspecialchars($data['contrasena']); ?>">
        <span><?= $data['eContrasena'] ?></span><br><br>

        <label for="passwordConfirm">Confirmar Contraseña:</label>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required value="<?php echo htmlspecialchars($data['passwordConfirm']); ?>"> 
        <span><?= $data['ePasswordConfirm'] ?></span><br><br>

        <label for="foto">Foto del Personaje:</label>
        <input type="file" id="foto" name="foto">
        <span><?= $data['eFoto'] ?></span><br><br>

        <label for="clase">Clase del Personaje:</label>
        <input type="text" id="clase" name="clase" value="<?= $data['clase'] ?>" required>
        <span><?= $data['eClase'] ?></span><br><br>

        <label for="raza">Raza del Personaje:</label>
        <input type="text" id="raza" name="raza" value="<?= $data['raza'] ?>" required>
        <span><?= $data['eRaza'] ?></span><br><br>

        <label for="armas">Armas del Personaje:</label>
        <input type="text" id="armas" name="armas" value="<?= $data['armas'] ?>" required>
        <span><?= $data['eArmas'] ?></span><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>