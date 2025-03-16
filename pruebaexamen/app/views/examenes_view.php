<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen</title>
</head>
<body>
<nav>
    <?php if (strlen($_SESSION['id']) == 0): ?>
        <button><a href="/registro/">Registrar</a></button>
        <form action="/login/" method="post">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <button><a href="/">Vista principal</a></button>
    <?php else: ?>
        <button><a href="/logout/">Cerrar sesión</a></button>
        <button><a href="/">Vista principal</a></button>
        <button><a href="/eliminarusuario/">Eliminar Usuario</a></button>
        <button><a href="/perfil/">Ver perfil</a></button>
    <?php endif; ?>
</nav>

<h1>Examen</h1>
<form action="" method="post">
    <select name="id_examen" required>
        <option value="">Seleccione un examen</option>
        <?php foreach ($data['examenes'] as $examen): ?>
            <option value="<?php echo $examen['id']; ?>"><?php echo $examen['titulo']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="realizarexamen">Realizar examen</button>
</form>

        <!--RADIO BUTTONS-->
<?php if (!empty($data['preguntas'])): ?>
<form action="" method="post">
    <input type="hidden" name="id_examen" value="<?php echo $data['id_examen']; ?>">
    <?php foreach ($data['preguntas'] as $pregunta): ?>
        <h2><?php echo $pregunta['enunciado']; ?></h2>
        <input type="hidden" name="id_pregunta[]" value="<?php echo $pregunta['id']; ?>">
        <input type="radio" name="respuesta[<?php echo $pregunta['id']; ?>]" value="A" required> <?php echo $pregunta['opcion_a']; ?><br>
        <input type="radio" name="respuesta[<?php echo $pregunta['id']; ?>]" value="B" required> <?php echo $pregunta['opcion_b']; ?><br>
        <input type="radio" name="respuesta[<?php echo $pregunta['id']; ?>]" value="C" required> <?php echo $pregunta['opcion_c']; ?><br>
        <input type="radio" name="respuesta[<?php echo $pregunta['id']; ?>]" value="D" required> <?php echo $pregunta['opcion_d']; ?><br>
    <?php endforeach; ?>
    <button type="submit" name="enviarexamen">Enviar respuestas</button>
</form>
<?php endif; ?>

    <!--SELECT-->
    <!-- <?php if (!empty($data['preguntas'])): ?>
    <form action="" method="post">
        <input type="hidden" name="id_examen" value="<?php echo $data['id_examen']; ?>">
        <?php foreach ($data['preguntas'] as $pregunta): ?>
            <h2><?php echo $pregunta['enunciado']; ?></h2>
            <input type="hidden" name="id_pregunta[]" value="<?php echo $pregunta['id']; ?>">
            <select name="respuesta[<?php echo $pregunta['id']; ?>]" required>
                <option value="">Seleccione una respuesta</option>
                <option value="A"><?php echo $pregunta['opcion_a']; ?></option>
                <option value="B"><?php echo $pregunta['opcion_b']; ?></option>
                <option value="C"><?php echo $pregunta['opcion_c']; ?></option>
                <option value="D"><?php echo $pregunta['opcion_d']; ?></option>
            </select>
        <?php endforeach; ?>
        <button type="submit" name="enviarexamen">Enviar respuestas</button>
    </form>
<?php endif; ?> -->

<!--checkbox-->
<!-- <?php if (!empty($data['preguntas'])): ?>
<form action="" method="post">
    <input type="hidden" name="id_examen" value="<?php echo $data['id_examen']; ?>">
    <?php foreach ($data['preguntas'] as $pregunta): ?>
        <h2><?php echo $pregunta['enunciado']; ?></h2>
        <input type="hidden" name="id_pregunta[]" value="<?php echo $pregunta['id']; ?>">
        
        <input type="checkbox" name="respuesta[<?php echo $pregunta['id']; ?>][]" value="A"> <?php echo $pregunta['opcion_a']; ?><br>
        <input type="checkbox" name="respuesta[<?php echo $pregunta['id']; ?>][]" value="B"> <?php echo $pregunta['opcion_b']; ?><br>
        <input type="checkbox" name="respuesta[<?php echo $pregunta['id']; ?>][]" value="C"> <?php echo $pregunta['opcion_c']; ?><br>
        <input type="checkbox" name="respuesta[<?php echo $pregunta['id']; ?>][]" value="D"> <?php echo $pregunta['opcion_d']; ?><br>
    <?php endforeach; ?>
    <button type="submit" name="enviarexamen">Enviar respuestas</button>
</form>
<?php endif; ?> -->


<?php if (isset($data['correctas']) && isset($data['incorrectas'])): ?>
    <h2>Resultados</h2>
    <p>Respuestas correctas: <?php echo $data['correctas']; ?></p>
    <p>Respuestas incorrectas: <?php echo $data['incorrectas']; ?></p>
    <p>Nota: <?php echo $data['nota'] ?></p>
<?php endif; ?>

</body>
</html>